<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/

// Managing the api call



/*
 * Route for RestApi OAuth
*/  

// Creating the instance of Dingo API Router for endpoints
$api = app('Dingo\Api\Routing\Router');

// Get access token
$api->version('v1', function($api) {
    /*$api->get('users', 'App\Http\Controllers\OAuthController@index');

    $api->get('users/{user_id}', 'App\Http\Controllers\OAuthController@show');*/
    $api->get('users', function() {
        return 'hi';
    });
});