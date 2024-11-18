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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

// $router->group(['prefix' => 'api'], function () use ($router){
//     $router->post('/register', 'UsersController@register');
//     $router->post('/login', 'UsersController@login');
//     $router->get('/auth/google', 'UsersController@redirectToGoogle');
//     $router->get('/auth/google/callback', 'UsersController@handleGoogleCallback');
// });

// $router->group(['prefix' => 'auth'], function () use ($router) {
//     $router->get('/user/profile', 'UsersController@profile');
// });

// $router->group(['middleware' => 'auth'], function () use ($router) {
//     $router->get('/complaints', 'ComplaintsController@index');
//     $router->post('/complaints', 'ComplaintsController@store');
//     $router->get('/complaints/{id}', 'ComplaintsController@show');
//     $router->put('/complaints/{id}', 'ComplaintsController@update');
//     $router->delete('/complaints/{id}', 'ComplaintsController@destroy');
// });

    // $router->get('/complaints', 'ComplaintsController@index');
    // $router->post('/complaints', 'ComplaintsController@store');
    // $router->get('/complaints/{id}', 'ComplaintsController@show');
    // $router->put('/complaints/{id}', 'ComplaintsController@update');
    // $router->delete('/complaints/{id}', 'ComplaintsController@destroy');

$router->group(['middleware' => 'cors'], function () use ($router) {
    $router->group(['prefix' => 'api'], function () use ($router){
        $router->post('/register', 'UsersController@register');
        $router->post('/login', 'UsersController@login');
        $router->get('/auth/google', 'UsersController@redirectToGoogle');
        $router->get('/auth/google/callback', 'UsersController@handleGoogleCallback');
    });

    $router->get('/complaints', 'ComplaintsController@index');
    $router->post('/complaints', 'ComplaintsController@store');
    $router->get('/complaints/{id}', 'ComplaintsController@show');
    $router->put('/complaints/{id}', 'ComplaintsController@update');
    $router->delete('/complaints/{id}', 'ComplaintsController@destroy');
});