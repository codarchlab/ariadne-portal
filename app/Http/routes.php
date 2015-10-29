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

Route::get('/', 'PageController@welcome');
Route::get('about', 'PageController@about');

Route::get('search', 'ResourceController@index');
Route::get('search', ['as'=> 'search', 'uses' => 'ResourceController@search']);

Route::get('provider', 'ProviderController@index');

Route::get('subject', 'SubjectController@index');

Route::get('map', 'MapController@index');
Route::post('map_results', 'MapController@results');

Route::get('browse', 'BrowseController@map');

Route::get('{type}/{id}','ResourceController@show' );
