<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 11:56 AM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'menu';
$subModuleRoute = 'menu-node';

//Backend
Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute, $subModuleRoute) {
    //Menu Position
    $router->group(['prefix' => $moduleRoute], function (Router $router) {
        $router->get('index', 'MenuController@getIndex')
            ->name('nqadmin::menu.index.get');
        $router->get('create', 'MenuController@getCreate')
            ->name('nqadmin::menu.create.get');
        $router->post('create', 'MenuController@postCreate')
            ->name('nqadmin::menu.create.post');
        $router->get('edit/{id}', 'MenuController@getEdit')
            ->name('nqadmin::menu.edit.get');
        $router->post('edit/{id}', 'MenuController@postEdit')
            ->name('nqadmin::menu.edit.post');
        $router->get('delete/{id}', 'MenuController@getDelete')
            ->name('nqadmin::menu.delete.get');
    });

    $router->group(['prefix' => $subModuleRoute], function (Router $router) {
        $router->get('edit/{id}', 'MenuNodeController@getEdit')
            ->name('nqadmin::menu-node.edit.get');
        $router->post('edit/{id}', 'MenuNodeController@postEdit')
            ->name('nqadmin::menu-node.edit.post');
    });
});