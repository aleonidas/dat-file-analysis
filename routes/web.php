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

$router->get('/', [
    'as' => 'home', 'uses' => 'FileController@index'
]);

$router->post('/upload', [
    'as' => 'home.upload', 'uses' => 'FileController@upload'
]);

$router->get('/processar', [
    'as' => 'process.index', 'uses' => 'ProcessController@index'
]);

$router->post('/processar', [
    'as' => 'process.store', 'uses' => 'ProcessController@store'
]);

$router->get('/relatorio', [
    'as' => 'process.report', 'uses' => 'ProcessController@report'
]);