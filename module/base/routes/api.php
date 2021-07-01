<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 11:51 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'dashboard';

Route::group(['prefix' => $moduleRoute], function(Router $router) use ($moduleRoute) {
    $router->group(['prefix' => 'ajax'], function (Router $router) {
        $router->post('get-course-in-company', 'DashboardController@getCourseInCompany')
            ->name('ajax.get-course-in-company');
    });
});