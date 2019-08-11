<?php

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

$router->post('auth/login', 'AuthController@authenticate');
$router->get('auth/login', 'AuthController@login');
$router->post('auth/register', 'AuthController@register');
$router->get('auth/register', 'AuthController@register');

$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
        $router->get('/', function () use ($router) {
            return redirect()->to('files');
        });
        
        $router->get('files', 'FilesController@list');
        $router->post('files/create', 'FilesController@create');
        $router->get('files/{id}/update', 'FilesController@update');
        $router->post('files/{id}/update', 'FilesController@update');
        $router->get('files/{id}/download', 'FilesController@download');
        $router->get('files/{id}/delete', 'FilesController@delete');
        
        $router->get('users', 'UsersController@list');
        $router->get('users/{id}/profile', 'UsersController@profile');
        $router->post('users/{id}/profile', 'UsersController@profile');
        $router->post('users', 'UsersController@create');
        $router->get('users/{id}/delete', 'UsersController@delete');

        $router->get('auth/logout', 'AuthController@logout');
    }
);

