<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/28/2018
 * Time: 11:12 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'media';

Route::group(['prefix' => $moduleRoute], function(Router $router) use ($moduleRoute) {
	$router->group(['prefix' => 'video'], function (Router $router) {
		$router->post( 'upload', 'MediaController@upload' );
		$router->get( 'get-list-video', 'MediaController@getListVideo' );
		$router->post( 'delete-video', 'MediaController@delete' );
		$router->post( 'update-curriculum-video', 'MediaController@updateCuriculumVideo' );
	});
	
	$router->group(['prefix' => 'resource'], function (Router $router) {
		$router->post('upload-resource', 'MediaController@uploadResource');
		$router->post('delete-resource', 'MediaController@deleteResource');
		$router->post('set-null-resource', 'MediaController@setNullResource');
		$router->get('get-list-resource', 'MediaController@getListResource');
		$router->post('update-resource', 'MediaController@updateResource');
	});
});