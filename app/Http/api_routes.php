<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/

//managing the api call
Route::group(['prefix' => 'api/v1'], function(){

    Route::controller('/','ApiController');
});