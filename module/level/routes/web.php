<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:22 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'level';

Route::group(['prefix' => $adminRoute], function(Router $router) use ($adminRoute, $moduleRoute) {
	$router->group( [ 'prefix' => $moduleRoute ], function ( Router $router ) use ( $adminRoute, $moduleRoute ) {
		$router->get( 'index', 'LevelController@getIndex' )
		       ->name( 'nqadmin::level.index.get' );
		
		$router->post( 'create', 'LevelController@postCreate' )
		       ->name( 'nqadmin::level.create.post' );
		
		$router->get( 'edit/{id}', 'LevelController@getEdit' )
		       ->name( 'nqadmin::level.edit.get' );
		
		$router->post( 'edit/{id}', 'LevelController@postEdit' )
		       ->name( 'nqadmin::level.edit.post' );
		
		$router->get( 'delete/{id}', 'LevelController@getDelete' )
		       ->name( 'nqadmin::level.delete.get' );
		
		$router->get( 'change-status/{id}', 'LevelController@changeStatus' )
		       ->name( 'nqadmin::level.changeStatus.get' );
		
		$router->get('set-featured/{id}', 'LevelController@setFeatured')
		       ->name('nqadmin::level.setFeatured.get');
	});
});

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->group( [ 'prefix' => 'trinh-do' ], function ( Router $router ) {
        $router->get('{slug}', 'LevelController@getList')
            ->name('front.level.list.get');
    });
});