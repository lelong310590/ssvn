<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2018
 * Time: 2:52 PM
 */

namespace Post\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'nqadmin-post');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    public function register()
    {
        $this->app->register(RouteProvider::class);
        $this->app->register(HookProvider::class);
    }

}