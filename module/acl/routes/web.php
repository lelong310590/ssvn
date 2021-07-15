<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:29 AM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'acl';

Route::group(['prefix' => $adminRoute.'/'.$moduleRoute], function(Router $router) use ($adminRoute, $moduleRoute) {
	$router->group(['prefix' => 'role', 'middleware' => 'verfiry-admin'], function(Router $router) {
		$router->get('index', 'RoleController@getIndex')
		       ->name('nqadmin::role.index.get')
		       ->middleware('permission:role_index');
		
		$router->get('create', 'RoleController@getCreate')
		       ->name('nqadmin::role.create.get')
		       ->middleware('permission:role_create');
		
		$router->post('create', 'RoleController@postCreate')
		       ->name('nqadmin::role.create.post')
		       ->middleware('permission:role_create');
		
		$router->get('edit/{id}', 'RoleController@getEdit')
		       ->name('nqadmin::role.edit.get')
		       ->where('id', '[0-9]+')
		       ->middleware('permission:role_edit');
		
		$router->post('edit/{id}', 'RoleController@postEdit')
		       ->name('nqadmin::role.edit.post')
		       ->where('id', '[0-9]+')
		       ->middleware('permission:role_edit');
		
		$router->get('delete/{id}', 'RoleController@getDelete')
		       ->name('nqadmin::role.delete.delete')
		       ->where('id', '[0-9]+')
		       ->middleware('permission:role_delete');
	});
	
	$router->group(['prefix' => 'permission'], function(Router $router) {
		$router->get('index', 'PermissionController@getIndex')
		       ->name('nqadmin::permission.index.get')
		       ->middleware('permission:permission_index');
	});
});
