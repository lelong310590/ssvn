<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/4/2018
 * Time: 10:16 AM
 */

namespace Cart\Providers;

use Base\Supports\Helper;
use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'nqadmin-cart');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cart.php', 'cart');

        Helper::loadModuleHelpers(__DIR__);
        $this->app->register(RouteProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(InstallModuleProvider::class);
        $this->app->register(HookProvider::class);
    }
}