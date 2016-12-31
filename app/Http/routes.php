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

//Route::get('/auth/github', 'Auth\SocialLoginController@githubLogin');
//Route::get('/github/callback', 'Auth\SocialLoginController@githubCallback');
//Route::get('/auth/twitter', 'Auth\SocialLoginController@twitterLogin');
//Route::get('/twitter/callback', 'Auth\SocialLoginController@twitterCallback');
//Route::get('/auth/google', 'Auth\SocialLoginController@googleLogin');
//Route::get('/google/callback', 'Auth\SocialLoginController@googleCallback');
Route::get('/auth/youtube', 'Auth\SocialLoginController@youtubeLogin');
Route::get('/youtube/callback', 'Auth\SocialLoginController@youtubeCallback');

Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/playlists', 'PlaylistController@index');
Route::get('/playlist/{playlist}/songs', 'SongController@index');
Route::get('/users', 'UserController@userList');
Route::get('/user/{user}', 'UserController@index');
Route::get('/user/{user}/follow', 'UserController@follow');
Route::get('/user/{user}/follower', 'UserController@follower');

Route::group(['middleware' => 'auth'], function(){

    Route::get('/favorites', 'FavoriteController@index');
    Route::post('/favorite', 'FavoriteController@store');
    Route::delete('/favorite/{favorite}', 'FavoriteController@destroy');
    Route::put('/favorite/{favorite}/like', 'FavoriteController@like');
    Route::put('/favorite/{favorite}/unlike', 'FavoriteController@unLike');

    Route::get('/my-playlists', 'PlaylistController@myPlaylists');
    Route::post('/playlist', 'PlaylistController@store');
    Route::put('/playlist/{playlist}', 'PlaylistController@update');
    Route::put('/playlist/{playlist}/like', 'PlaylistController@like');
    Route::put('/playlist/{playlist}/unlike', 'PlaylistController@unLike');
    Route::delete('/playlist/{playlist}', 'PlaylistController@destroy');

    Route::post('/song', 'SongController@store');
    Route::delete('/song/{song}', 'SongController@destroy');
    Route::put('/song/{song}/like', 'SongController@like');
    Route::put('/song/{song}/unlike', 'SongController@unLike');
    Route::get('/my-songs', 'SongController@mySongs');

    Route::post('/follow', 'FollowController@follow');
    Route::post('/unfollow', 'FollowController@unfollow');

    Route::get('/mypage', 'MyPageController@index');
    Route::get('/mypage/likes', 'MyPageController@likes');
    Route::get('/mypage/edit/{user}', 'MyPageController@editView');
    Route::post('/mypage/edit/{user}', 'MyPageController@editUpdate');
});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function(){
    Route::get('/playlists', 'PlaylistController@apiIndex');
    //Route::post('/playlist', 'PlaylistController@store');
    Route::get('/playlist', 'PlaylistController@store');
    //Route::post('/song', 'SongController@store');
    Route::get('/song', 'SongController@store');
    //Route::post('/favorite', 'FavoriteController@store');
    Route::get('/favorite', 'FavoriteController@store');
});
