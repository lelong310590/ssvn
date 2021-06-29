<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 11:54 AM
 */

namespace Menu\Providers;

use Base\Supports\Helper;
use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'nqadmin-menu');
    }

    public function register()
    {
        $this->app->register(RouteProvider::class);
        $this->app->register(HookProvider::class);

        Helper::loadModuleHelpers(__DIR__);
    }
}