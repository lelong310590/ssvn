<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 1:42 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'qa';

Route::group(['prefix' => $moduleRoute], function(Router $router) use ($moduleRoute) {
    $router->group(['prefix' => 'question'], function (Router $router) {
        $router->get('list-question', 'QAController@listQuestion');
        $router->post('post-question', 'QAController@postQuestion');
        $router->post('edit-question', 'QAController@editQuestion');
        $router->get('delete-question', 'QAController@deleteQuestion');
    });

    $router->group(['prefix' => 'answer'], function (Router $router) {
        $router->post('post-answer', 'QAController@postAnswer');
        $router->get('list-answer', 'QAController@listAnswer');
        $router->post('edit-answer', 'QAController@editAnswer');
    });
});