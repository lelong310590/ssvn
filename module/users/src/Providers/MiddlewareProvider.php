<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/13/2018
 * Time: 1:53 PM
 */

namespace Users\Providers;

use Illuminate\Support\ServiceProvider;
use Users\Http\Middleware\CheckCourseOwner;

class MiddlewareProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('check-course-owner', CheckCourseOwner::class);
    }
}