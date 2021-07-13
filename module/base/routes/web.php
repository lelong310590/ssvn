<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 11:51 PM
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'dashboard';

//Backend
Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
        $router->get('index', 'DashboardController@getIndex')->name('nqadmin::dashboard.index.get');
        $router->get('/sendmail/{id}', 'DashboardController@testMail');
    });
});


//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->get('/', 'HomeController@getIndex')
        ->name('front.home.index.get');
    $router->get('tro-thanh-giao-vien', 'HomeController@trothanhgiaovien')
        ->name('front.home.trothanhgiaovien');
    $router->post('loadquickview', 'HomeController@loadquickview')
        ->name('front.home.quickview.get');
    $router->post('searchsuggest', 'HomeController@searchsuggest')
        ->name('front.home.search.suggest');
    //search
    $router->get('/search', 'HomeController@search')
        ->name('front.home.search');

//    $router->get('update-question', 'HomeController@updateQuestion');
//    $router->get('update-question-reason', 'HomeController@updateQuestionReason');
//    $router->get('update-answer', 'HomeController@updateAnswer');
//    $router->get('update-result', 'HomeController@updateResult');
    $router->get('update-result-detail', 'HomeController@updateResultDetail');
    $router->get('update-position', 'HomeController@updatePosition');
});