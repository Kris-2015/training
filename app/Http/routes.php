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

Route::get('activation/{token}', 'AuthController@activateUser');

Route::get('/dashboard',function()
{
    return view('/dashboard');
});

Route::get('logout', 'AuthController@logout');

Route::get('list', 'HomeController@getlist');

Route::get('bio',
    ['as'=>'bio',
    'uses'=>'BioController@people']);

Route::controller('datatables', 'UserController');

Route::get('register/{id}', 'HomeController@Data');

Route::post('delete','HomeController@delete');