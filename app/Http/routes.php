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

Route::get('search', [
    'as'=> 'search',
    'uses' => 'ResourceController@search',
    'middleware' => ['negotiate:resource.search']
]);

Route::get('provider', 'ProviderController@index');

Route::get('subject', 'SubjectController@index');

Route::get('browse/map', 'BrowseController@map');
Route::get('browse/when', 'BrowseController@when');

Route::get('resource/{id}', [
    'uses' => 'ResourceController@show',
    'middleware' => ['negotiate:resource.show']
]);

Route::get('robots.txt','PageController@robots' );
