<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 11:51 PM
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'advertise';

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->group(['prefix' => 'advertise', 'middleware' => 'verfiry-admin'], function (Router $router) {
        $router->post('/update', 'AdvertiseController@update')
            ->name('front.advertise.update.post');
    });
});