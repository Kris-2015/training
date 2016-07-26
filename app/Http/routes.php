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

Route::get('/profile', ['as' => 'profile', function () {
    return 'hello';
}]);

Route::get('profile/{name}', function ($name) {
	return 'Hello ' . $name;
})->where('name', '[A-Za-z]+');

/*Route::get('profile/{name?}’, function ($name = ‘Scott’) {
    		return 'Hello ' . $name;
       })->where('name', '[A-Za-z]+');*/

/*Route::group(['prefix' => 'admin'], function () {
    Route::get('users', function ()    {
        // Matches The "/admin/users" URL
        return 'hii neo';ame
    });*/
Route::get('calculator/add/{id}/{id2}', function ($id, $id2) {
    return "Add " . ($id + $id2);
})
->where(['id' => '[0-9./-]+', 'id2' => '[0-9./-]+']);

Route::get('calculator/sub/{id}/{id2}', function ($id, $id2) {
    return "Subtraction " . ($id - $id2);
})
->where(['id' => '[0-9./-]+', 'id2' => '[0-9./-]+']);

Route::get('calculator/multi/{id}/{id2}', function ($id, $id2) {
    return "Multiplication " . ($id * $id2);
})
->where(['id' => '[0-9./-]+', 'id2' => '[0-9./-]+']);

Route::get('calculator/div/{id}/{id2}', function ($id, $id2) {
    return "Division " . ($id / $id2);
})
->where(['id' => '[0-9./-]+', 'id2' => '[0-9./-]+']);

Route::get('calculator/mod/{id}/{id2}', function ($id, $id2) {
    return "Modulus Operation " . ($id % $id2);
})
->where(['id' => '[0-9./-]+', 'id2' => '[0-9./-]+']);

Route::get('register', 
    ['as' => 'register',
     'uses' => 'RegistrationController@register']);

Route::post('do-register', ['as' => 'do-register', 'uses' => 'RegistrationController@doRegister']);

Route::get('login', 
    ['as' => 'login',
     'uses'=>'LoginController@login']);

Route::post('dologin', ['as' => 'dologin', 'uses' => 'LoginController@dologin']);

//Route::get('bio','BioController@people');
Route::get('bio',
    ['as'=>'bio',
    'uses'=>'BioController@people']);
//----------------------------------------------
Route::get('users', function(){
    $users = App\Employee::find(1);
    echo $users;
    //print_r($users);
});

Route::get('gadget', function(){
    $gadget = App\Gadget::find(2);

    echo $gadget->gadget_name;
    //print_r($gadget);
});