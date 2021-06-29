<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/27/2018
 * Time: 2:09 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'ctv';

Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {

    });
});


//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->get('ctv/register', 'CtvController@getRegister')
        ->name('nqadmin::get.registerctv')->middleware('auth');
    $router->get('ctv/registerpost', 'CtvController@postRegister')
        ->name('nqadmin::post.registerctv')->middleware('auth');
    $router->get('ctv/thongke', 'CtvController@thongke')
        ->name('nqadmin::get.thongkectv')->middleware('auth');
});