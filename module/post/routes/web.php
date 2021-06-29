<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2018
 * Time: 2:50 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'post';

//Backend
Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
        $router->get('list', 'PostController@getList')
            ->name('nqadmin::post.list.get');

        $router->get('index', 'PostController@getIndex')
            ->name('nqadmin::post.index.get');

        $router->get('create', 'PostController@getCreate')
            ->name('nqadmin::post.create.get');

        $router->post('create', 'PostController@postCreate')
            ->name('nqadmin::post.create.post');

        $router->get('edit/{id}','PostController@getEdit')
            ->name('nqadmin::post.edit.get');

        $router->post('edit/{id}', 'PostController@postEdit')
            ->name('nqadmin::post.edit.post');

        $router->get('delete/{id}', 'PostController@getDelete')
            ->name('nqadmin::post.delete.get');
    });
});