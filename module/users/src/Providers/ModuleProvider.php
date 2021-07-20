<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 2:12 PM
 */

namespace Users\Providers;

use Barryvdh\Debugbar\ServiceProvider;
use Base\Supports\Helper;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'nqadmin-users');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/meta.php', 'meta');

        Helper::loadModuleHelpers(__DIR__);
        $this->app->register(RouteProvider::class);
        $this->app->register(HookProvider::class);
        $this->app->register(InstallModuleProvider::class);
        $this->app->register(MiddlewareProvider::class);
        $this->app->register(EventServiceProvider::class);
    }
}