<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:03 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'pricetier';

Route::group(['prefix' => $adminRoute], function(Router $router) use ($adminRoute, $moduleRoute) {
	$router->group( [ 'prefix' => $moduleRoute ], function ( Router $router ) use ( $adminRoute, $moduleRoute ) {
		$router->get( 'index', 'PriceTierController@getIndex' )
		       ->name( 'nqadmin::pricetier.index.get' );
		
		$router->post( 'create', 'PriceTierController@postCreate' )
		       ->name( 'nqadmin::pricetier.create.post' );
		
		$router->get( 'edit/{id}', 'PriceTierController@getEdit' )
		       ->name( 'nqadmin::pricetier.edit.get' );
		
		$router->post( 'edit/{id}', 'PriceTierController@postEdit' )
		       ->name( 'nqadmin::pricetier.edit.post' );
		
		$router->get( 'delete/{id}', 'PriceTierController@getDelete' )
		       ->name( 'nqadmin::pricetier.delete.get' );
		
		$router->get( 'change-status/{id}', 'PriceTierController@changeStatus' )
		       ->name( 'nqadmin::pricetier.changeStatus.get' );
	});
});