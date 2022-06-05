<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\ProductController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->get('/products', 'ProductController@getProducts');
});



$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->post('/login', 'UserController@register');

    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        $router->post('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
        $router->post('reset-email', ['as' => 'reset-email', 'uses' => 'UserController@resetEmail']);
    });
});
