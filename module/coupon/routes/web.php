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
$moduleRoute = 'coupon';

Route::group(['prefix' => $adminRoute], function(Router $router) use ($adminRoute, $moduleRoute) {
    $router->group( [ 'prefix' => $moduleRoute, 'middleware' => 'verfiry-admin' ], function ( Router $router ) use ( $adminRoute, $moduleRoute ) {
        $router->post( 'create', 'CouponController@postCreate' )
            ->name( 'nqadmin::coupon.create.post' );
        $router->post( 'changeStatus', 'CouponController@changeStatus' )
            ->name( 'nqadmin::coupon.changestt.post' );

    });
});