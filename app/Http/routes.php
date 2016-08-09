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

// auth route
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/favorites', 'FavoriteController@index');
    Route::post('/favorite', 'FavoriteController@store');
    Route::delete('/favorite/{favorite}', 'FavoriteController@destroy');

    Route::get('/playlists', 'PlaylistController@index');
    Route::get('/my-playlists', 'PlaylistController@myPlaylists');
    Route::post('/playlist', 'PlaylistController@store');
    Route::delete('/playlist/{playlist}', 'PlaylistController@destroy');

    Route::get('/playlist/{playist}/songs', 'SongController@index');
    Route::post('/song', 'SongController@store');
    Route::delete('/song/{song}', 'SongController@destroy');
    Route::put('/song/{song}/like', 'SongController@like');
});

Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('/github/callback', 'Auth\AuthController@handleProviderCallback');
