<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:58 PM
 */

namespace Advertise\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'nqadmin-advertise');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function register()
    {
//        $this->mergeConfigFrom(__DIR__ . '/../../config/setting.php', 'setting');

        $this->app->register(RouteProvider::class);
//        $this->app->register(InstallModuleProvider::class);
    }
}