<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 2:24 PM
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'messages';

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->group(['prefix' => 'messages'], function (Router $router) {
        $router->get('thread/{message_id?}', 'MessagesController@index')
            ->name('front.message.index.get')->middleware('auth');

        $router->get('user/{user_id?}', 'MessagesController@create')
            ->name('front.message.create.get')->middleware('auth');

        $router->post('send', 'MessagesController@send')
            ->name('front.message.send.post')->middleware('auth');

        $router->post('searchuser', 'MessagesController@searchUser')
            ->name('front.message.search.user')->middleware('auth');

        $router->post('setstar', 'MessagesController@setStar')
            ->name('front.message.star.post')->middleware('auth');
    });
});

