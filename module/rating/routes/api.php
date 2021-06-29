<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'rating';

Route::group(['prefix' => $moduleRoute], function(Router $router) use ($moduleRoute) {
    $router->post('post-rating', 'RatingController@postRating');
    $router->get('check-is-rated', 'RatingController@checkIsRated');
});