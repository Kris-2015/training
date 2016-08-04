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

Route::get('activation/{token}', 'AuthController@activateUser');

Route::get('/logout',['as' => 'logout', function () {
    Auth::logout();
    Session::flush();
    return redirect()->route('login');
}]);

Route::get('/resetPassword',[
    'as' => 'sendLink',
    'uses' => 'ResetPasswordController@sendLink'
]);

Route::post('resetPassword', [
    'as' => 'resetPassword', 
    'uses' => 'ResetPasswordController@reset'
]);

Route::get('reset/{token}', 'ResetPasswordController@PasswordPage');

Route::post('updatepassword', [
    'as' => 'updatepassword',
    'uses'=>'ResetPasswordController@updatepassword'
]);
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

    Route::get('delete','HomeController@delete');

    Route::get('/dashboard',[
        'middleware'=>'auth',
        'uses' => 'HomeController@dashboard'
    ]);
    Route::get('panel', 'AccessController@showPanel');

    Route::post('panel/getrrp','AccessController@getrrp');

    Route::post('panel/perm','AccessController@getPerm');

    Route::post('panel/setpermission', 'AccessController@setPermission');
});