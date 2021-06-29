<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 1:42 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'setting';

Route::group(['prefix' => $adminRoute], function(Router $router) use ($adminRoute, $moduleRoute) {
    $router->group( [ 'prefix' => $moduleRoute ], function ( Router $router ) use ( $adminRoute, $moduleRoute ) {

        $router->get( 'index', 'SettingController@getSetting' )
            ->name( 'nqadmin::setting.index.get' );
//            ->middleware( 'permission:setting_index' );

        $router->get( 'top', 'SettingController@getIndex' )
            ->name( 'nqadmin::setting.top.get' );
//            ->middleware( 'permission:course_index' );

        $router->post( 'top', 'SettingController@postIndex' )
            ->name( 'nqadmin::setting.top.post' );

        $router->get( 'sale', 'SettingController@getSale' )
            ->name( 'nqadmin::setting.sale.get' );

        $router->get( 'create-sale', 'SettingController@createSale' )
            ->name( 'nqadmin::setting.createsale.get' );

        $router->post( 'post-create-sale', 'SettingController@postcreateSale' )
            ->name( 'nqadmin::setting.createsale.post' );

        //enable sale post
        $router->get( 'enable-post/{id}', 'SettingController@enableSale')
            ->name( 'nqadmin::sale.enable.post');

        $router->get('seo', 'SettingController@seoIndex')
            ->name('nqadmin::seo.index');
        $router->post('seo', 'SettingController@seoPost')
            ->name('nqadmin::seo.post');
    });
});

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {

});