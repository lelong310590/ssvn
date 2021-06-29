<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/12/2018
 * Time: 11:47 AM
 */

namespace Messages\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'nqadmin-messages');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function register()
    {
        $this->app->register(RouteProvider::class);
    }
}