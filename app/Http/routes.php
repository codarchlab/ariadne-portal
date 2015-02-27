<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');
Route::get('about', 'WelcomeController@about');

Route::get('home', 'HomeController@index');


Route::get('provider', 'ProviderController@index');

Route::get('subject', 'SubjectController@index');

Route::get('collection', 'CollectionController@index');
Route::get('collection/{id}', 'CollectionController@show');

Route::get('dataset', 'DatasetController@index');
Route::get('dataset/{id}', 'DatasetController@show');

Route::get('agent', 'AgentController@index');
Route::get('agent/{id}', 'AgentController@show');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
