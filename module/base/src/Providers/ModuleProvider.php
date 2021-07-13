<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/30/2017
 * Time: 10:58 PM
 */

namespace Base\Providers;

use ClassLevel\Models\ClassLevel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Base\Supports\Helper;
use Illuminate\Support\Facades\View;
use Setting\Models\Sale;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'nqadmin-dashboard');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../resources/public' => public_path(),
        ], 'nqadmin-public-assets');

        $this->app->booted(function () {
            $this->booted();
        });
    }

    public function booted()
    {
        $currentUrl = url()->current();
        $check = explode('/', $currentUrl);
        $courseUrl = in_array('course', $check);
        View::share('isCourse', $courseUrl);

        if (Schema::hasTable('sale')) {
            $sale = Sale::where('status', 'active')
                ->where('start_time', '<=', date('Y-m-d H:i:s'))
                ->where('end_time', '>=', date('Y-m-d H:i:s'))
                ->orderBy('id', 'desc')
                ->get();

            $this->app->singleton('sale_system', function ($app) use ($sale) {
                return $sale;
            });
        }

        if (Schema::hasTable('classlevel')) {
            $allClassLevel = ClassLevel::where('status', 'active')
                ->orderBy('name', 'desc')
                ->get();

            View::share('allClassLevel', $allClassLevel);
        }
    }

    public function register()
    {
        //Load helpers
        Helper::loadModuleHelpers(__DIR__);

        config([
            'auth.defaults' => [
                'guard' => 'nqadmin',
                'passwords' => 'admin-users',
            ],
            'auth.guards.nqadmin' => [
                'driver' => 'session',
                'provider' => 'admin-users',
            ],
            'auth.providers.admin-users' => [
                'driver' => 'eloquent',
                'model' => \Users\Models\Users::class,
                'table' => 'users'
            ],
            'auth.passwords.admin-users' => [
                'provider' => 'admin-users',
                'table' => 'password_resets',
                'expire' => 60,
            ],
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../config/base.php', 'base');
        $this->mergeConfigFrom(__DIR__ . '/../../config/lfm.php', 'lfm');
        $this->mergeConfigFrom(__DIR__ . '/../../config/messages.php', 'messages');

        $this->publishes([
            __DIR__ . '/../../../../vendor/unisharp/laravel-filemanager/public' => public_path('vendor/laravel-filemanager'),
        ], 'public');

        /**
         * Module provider
         */
        $this->app->register(RouteProvider::class);
        $this->app->register(ConsoleProvider::class);


        //Register related facades
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        $loader->alias('Image', \Intervention\Image\Facades\Image::class);
        $loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);
        $loader->alias('Socialite', \Laravel\Socialite\Facades\Socialite::class);
        $loader->alias('Agent', \Jenssegers\Agent\Facades\Agent::class);

        /**
         * Other packages
         */
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        $this->app->register(\Intervention\Image\ImageServiceProvider::class);
        $this->app->register(\Prettus\Repository\Providers\RepositoryServiceProvider::class);
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);
        $this->app->register(\Unisharp\Laravelfilemanager\LaravelFilemanagerServiceProvider::class);
        $this->app->register(\Laravel\Socialite\SocialiteServiceProvider::class);

        /**
         * Other module providers
         */
        $this->app->register(\Auth\Providers\ModuleProvider::class);
        $this->app->register(\Hook\Providers\ModuleProvider::class);
        $this->app->register(\Acl\Providers\ModuleProvider::class);
        $this->app->register(\Users\Providers\ModuleProvider::class);
        $this->app->register(\Course\Providers\ModuleProvider::class);
        $this->app->register(\ClassLevel\Providers\ModuleProvider::class);
        $this->app->register(\Subject\Providers\ModuleProvider::class);
        $this->app->register(\Level\Providers\ModuleProvider::class);
        $this->app->register(\PriceTier\Providers\ModuleProvider::class);
        $this->app->register(\Tag\Providers\ModuleProvider::class);
        $this->app->register(\Media\Providers\ModuleProvider::class);
        $this->app->register(\Cart\Providers\ModuleProvider::class);
        $this->app->register(\MultipleChoices\Providers\ModuleProvider::class);
        $this->app->register(\Coupon\Providers\ModuleProvider::class);
        $this->app->register(\Rating\Providers\ModuleProvider::class);
        $this->app->register(\Qa\Providers\ModuleProvider::class);
        $this->app->register(\Setting\Providers\ModuleProvider::class);
        $this->app->register(\Notify\Providers\ModuleProvider::class);
        $this->app->register(\Messages\Providers\ModuleProvider::class);
        $this->app->register(\Post\Providers\ModuleProvider::class);
        $this->app->register(\Advertise\Providers\ModuleProvider::class);
        $this->app->register(\Ctv\Providers\ModuleProvider::class);
        $this->app->register(\Menu\Providers\ModuleProvider::class);
    }
}