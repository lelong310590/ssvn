<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 2:57 PM
 */

namespace Coupon\Providers;

use Base\Supports\Helper;
use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'nqadmin-coupon');
    }

    public function register()
    {
        Helper::loadModuleHelpers(__DIR__);
        $this->app->register(RouteProvider::class);
    }
}