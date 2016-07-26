<?php

namespace App\Http\Controllers;
use App\Employee;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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

        $email = $request->email_id;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            //if the condition is true, redirect to home page
            return redirect('/dashboard');  
        }
        else {
            return "Login Failed";
        }
    }
}