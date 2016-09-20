<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/
  
Route::group(['prefix' => 'oauth'], function(){
    Route::post('access_token&redirect=https://www.getpostman.com/oauth2/callback','OAuthController@accessToken');
});

Route::group(['prefix' => 'api/v1'], function(){
    Route::post('users','OAuthController@index');
    Route::post('users/{id}','OAuthController@show');
});