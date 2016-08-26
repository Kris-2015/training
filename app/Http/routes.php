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
    if(Auth::check())
    {
        return redirect('dashboard');
    }
    else
    {
        return view('login');
    }
});

Route::get('register', [
    'as' => 'register',
    'uses' => 'AuthController@register'
]);

Route::post('do-register', [
    'as' => 'do-register', 
    'uses' => 'AuthController@doRegister'
]);

Route::get('login', [
    'as' => 'login',
    'uses'=>'AuthController@login'
]);

Route::post('dologin', [
    'as' => 'dologin', 
    'uses' => 'AuthController@dologin'
]);

Route::get('instagram-register', [
    'as' => 'instagram-register',
    'uses' => 'InstagramController@details'
]);

Route::get('activation/{token}', 'AuthController@activateAccount');

Route::get('logout','AuthController@logout');

Route::get('/resetPassword',[
    'as' => 'sendLink',
    'uses' => 'ResetPasswordController@sendLink'
]);

Route::post('resetPassword', [
    'as' => 'resetPassword', 
    'uses' => 'ResetPasswordController@reset'
]);

Route::get('reset/{token}', 'ResetPasswordController@passwordPage');

Route::get('/dashboard','HomeController@dashboard');

Route::post('updatepassword', [
    'as' => 'updatepassword',
    'uses'=>'ResetPasswordController@updatePassword'
]);

Route::get('new_user',[
   'as' => 'new_user',
   'uses' => 'AddUserController@newUser'
]);

Route::post('add_user',[
   'as' => 'add_user',
   'uses' => 'AddUserController@add_user'
]);

Route::post('activate', 'ActivateUserController@activateUser');

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Route::post('image', 'UploadController@upload');

Route::get('map', 'MapController@map');

/**
 * Group routes to check the user authentication
*/
Route::group(['middleware'=>'auth'], function(){

    Route::get('list', [
        'middleware'=>'auth',
        'uses'=> 'HomeController@getlist'
    ]);

    Route::controller('datatables', 'UserController');

    Route::get('register/{id}', 'HomeController@Data');

    Route::post('delete','HomeController@delete');

    Route::get('panel', 'AccessController@showPanel');

    Route::post('panel/getrrp','AccessController@getrrp');

    Route::post('panel/permission','AccessController@getPermission');

    Route::post('panel/setpermission', 'AccessController@setPermission');
});