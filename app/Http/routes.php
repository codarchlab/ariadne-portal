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
Route::get('provider/{id}/collection', 'ProviderController@collection');
Route::get('provider/{id}/dataset', 'ProviderController@dataset');
Route::get('provider/{id}/database', 'ProviderController@database');
Route::get('provider/{id}/gis', 'ProviderController@gis');
Route::get('provider/{id}/schema', 'ProviderController@schema');
Route::get('provider/{id}/service', 'ProviderController@service');
Route::get('provider/{id}/vocabulary', 'ProviderController@vocabulary');
Route::get('provider/{id}/agent', 'ProviderController@agent');

Route::get('subject', 'SubjectController@index');

Route::get('collection', 'CollectionController@index');
Route::get('collection/{id}', 'CollectionController@show');

Route::get('dataset', 'DatasetController@index');
Route::get('dataset/{id}', 'DatasetController@show');

Route::get('database', 'DatabaseController@index');
Route::get('database/{id}', 'DatabaseController@show');

Route::get('gis', 'GisController@index');
Route::get('gis/{id}', 'GisController@show');

Route::get('metaSchema', 'MetaSchemaController@index');
Route::get('metaSchema/{id}', 'MetaSchemaController@show');

Route::get('service', 'ServiceController@index');
Route::get('service/{id}', 'ServiceController@show');

Route::get('vocabulary', 'VocabularyController@index');
Route::get('vocabulary/{id}', 'VocabularyController@show');

Route::get('agent', 'AgentController@index');
Route::get('agent/{id}', 'AgentController@show');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
