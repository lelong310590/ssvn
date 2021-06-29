<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:47 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'classlevel';

Route::group(['prefix' => $adminRoute], function(Router $router) use ($adminRoute, $moduleRoute) {
	$router->group( [ 'prefix' => $moduleRoute ], function ( Router $router ) use ( $adminRoute, $moduleRoute ) {
		$router->get( 'index', 'ClassLevelController@getIndex' )
		       ->name( 'nqadmin::classlevel.index.get' );
		
		$router->post( 'create', 'ClassLevelController@postCreate' )
		       ->name( 'nqadmin::classlevel.create.post' );
		
		$router->get( 'edit/{id}', 'ClassLevelController@getEdit' )
		       ->name( 'nqadmin::classlevel.edit.get' );
		
		$router->post( 'edit/{id}', 'ClassLevelController@postEdit' )
		       ->name( 'nqadmin::classlevel.edit.post' );
		
		$router->get( 'delete/{id}', 'ClassLevelController@getDelete' )
		       ->name( 'nqadmin::classlevel.delete.get' );
		
		$router->get( 'change-status/{id}', 'ClassLevelController@changeStatus' )
		       ->name( 'nqadmin::classlevel.changeStatus.get' );
	});
});

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->group( [ 'prefix' => 'lop' ], function ( Router $router ) {
        $router->get('{slug}', 'ClassLevelController@getClass')
            ->name('front.classlevel.index.get');
    });
});