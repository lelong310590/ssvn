<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/13/2018
 * Time: 1:53 PM
 */

namespace Course\Providers;

use Course\Http\Middleware\CheckAssistant;
use Course\Http\Middleware\CheckCourseActive;
use Course\Http\Middleware\CheckExam;
use Illuminate\Support\ServiceProvider;
use Course\Http\Middleware\CheckCourse;

class MiddlewareProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('check-course-active', CheckCourseActive::class);
        $router->aliasMiddleware('check-course', CheckCourse::class);
        $router->aliasMiddleware('check-assistant', CheckAssistant::class);
        $router->aliasMiddleware('check-exam', CheckExam::class);
    }
}