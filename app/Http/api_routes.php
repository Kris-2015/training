<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/


/*
 * Route for RestApi OAuth
*/  
Route::group(['prefix' => 'oauth'], function(){
    Route::post('access_token','OAuthController@accessToken');
});

Route::group(['prefix' => 'api/v1'], function(){
    Route::post('users','OAuthController@index');
    Route::post('users/{id}','OAuthController@show');
});

