<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 5:17 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'subject';

Route::group(['prefix' => $adminRoute], function(Router $router) use ($adminRoute, $moduleRoute) {
	$router->group( [ 'prefix' => $moduleRoute ], function ( Router $router ) use ( $adminRoute, $moduleRoute ) {
		$router->get( 'index', 'SubjectController@getIndex' )
		       ->name( 'nqadmin::subject.index.get' );
		
		$router->post( 'create', 'SubjectController@postCreate' )
		       ->name( 'nqadmin::subject.create.post' );
		
		$router->get( 'edit/{id}', 'SubjectController@getEdit' )
		       ->name( 'nqadmin::subject.edit.get' );
		
		$router->post( 'edit/{id}', 'SubjectController@postEdit' )
		       ->name( 'nqadmin::subject.edit.post' );
		
		$router->get( 'delete/{id}', 'SubjectController@getDelete' )
		       ->name( 'nqadmin::subject.delete.get' );
	});
});

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->group( [ 'prefix' => 'mon-hoc' ], function ( Router $router ) {
        $router->get('{class}/{subject}', 'SubjectController@getSubject')
            ->name('front.subject.index.get');
    });
});