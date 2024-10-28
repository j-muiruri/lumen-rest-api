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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/task', ['uses' =>'TaskController@index']);
$router->get('/task/{id}', ['uses' =>'TaskController@show']);
$router->post('/task', ['uses' =>'TaskController@store']);
$router->put('/task/{id}', ['uses' =>'TaskController@update']);
$router->delete('/task/{id}', ['uses' =>'TaskController@destroy']);