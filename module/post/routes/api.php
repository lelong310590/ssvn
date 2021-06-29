<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2018
 * Time: 2:50 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'post';

Route::group(['prefix' => $moduleRoute], function(Router $router) use ($moduleRoute) {
    $router->get('get-post', 'ApiPostController@getPost');
});