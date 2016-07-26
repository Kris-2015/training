<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
	* Show the login page
	*
	* @param  Request  $request
    */
    public function login(Request $request)
    {
    	return view('login');
    }
    /*
    * Processing the login page data
    *
    *  @param  Request  $request
    */
    public function dologin(Request $request)
    {
       $message['email_id.required'] = 'Email id required';
       $message['password.required'] = 'Give your password';

       $this->validate($request, [
            'email_id' => 'required',
            'password' => 'required'
        ], $message);

       echo $request->email_id;
        print_r($request->only('email_id','password'));
    }
}