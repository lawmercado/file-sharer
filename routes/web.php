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

$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
        $router->get('/', function () use ($router) {
            return redirect()->to('files');
        });
        
        $router->get('files', 'FilesController@list');
        $router->post('files', 'FilesController@create');
        $router->get('files/{id}', 'FilesController@update');
        $router->post('files/{id}', 'FilesController@update');
        $router->get('files/{id}/download', 'FilesController@download');
        $router->delete('files/{id}', 'FilesController@delete');
        
        $router->get('users', 'UsersController@list');
        $router->post('users', 'UsersController@create');
        $router->get('users/{id}', 'UsersController@get');
        $router->delete('users/{id}', 'UsersController@delete');

        $router->get('auth/logout', 'AuthController@logout');
    }
);

