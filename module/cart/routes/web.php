<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/4/2018
 * Time: 10:19 AM
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'checkout';

Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->group(['prefix' => $moduleRoute, 'middleware' => 'verfiry-admin'], function (Router $router) use ($adminRoute, $moduleRoute) {
        $router->get('/', 'CartController@getSetting')
            ->name('nqadmin::checkout.setting.get');

        $router->get('index', 'CartController@index')
            ->name('nqadmin::checkout.index.get');

        $router->get('create', 'CartController@create')
            ->name('nqadmin::checkout.create.get');

        $router->post('store', 'CartController@store')
            ->name('nqadmin::checkout.store.post');

        $router->get('{id}/detail', 'CartController@show')
            ->name('nqadmin::checkout.detail.get');

        $router->post('{id}/update', 'CartController@update')
            ->name('nqadmin::checkout.update.post');

        $router->post('addtocart', 'CartController@postAddToCart')
            ->name('nqadmin::checkout.cart.addtocart.post');

        $router->post('removetocart', 'CartController@postRemoveToCart')
            ->name('nqadmin::checkout.cart.removetocart.post');
    });
});

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->group(['prefix' => 'cart'], function (Router $router) {
        $router->post('addtocart', 'CartController@postAddToCart')
            ->name('front.cart.addtocart.post');

        $router->post('addtocheckout', 'CartController@postAddToCheckout')
            ->name('front.cart.addtocheckout.post')->middleware('auth');

        $router->post('removetocart', 'CartController@postRemoveToCart')
            ->name('front.cart.removetocart.post');

        $router->get('checkout', 'CartController@getCheckout')
            ->name('front.cart.checkout.get')->middleware(['auth', 'cart']);

        $router->post('checkout', 'CartController@postSendPayment')
            ->name('front.cart.checkout.post')->middleware(['auth', 'cart']);

        $router->post('checkoutfree/{id}', 'CartController@postSendPaymentFree')
            ->name('front.cart.checkoutfree.post')->middleware(['auth']);

        $router->get('callback', 'CartController@getNganLuongCallback')
            ->name('front.cart.callback.get')->middleware('auth');

        $router->get('cancel', 'CartController@getNganLuongCancel')
            ->name('front.cart.cancel.get')->middleware('auth');
    });
});