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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('/album/create', 'AlbumController@create');
Route::post('/album/store', 'AlbumController@store');
Route::get('/album/', 'AlbumController@index');
Route::get('/album/first', 'AlbumController@first');

Route::get('/home', 'HomeController@index');
