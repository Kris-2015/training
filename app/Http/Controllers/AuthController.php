<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserActivation;
use App\Models\Role;
use App\Models\Helper;
use Session;
use Auth;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Http\Requests\RegistrationRequest;


/**
 * Manage Login and registration request
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
*/

class AuthController extends Controller
{
    
    /**
     * Show registration form
     *
     * @param  Request  $request
     * @return mixed
    */
    public function register(Request $request)
    {
        if (Auth::check())
        {
            // The user is logged in...
            return redirect('dashboard');
        }

        //storing the list of states from config/state_list
        $state_list = config('constants.state_list');
        $users_info = NULL;
        return view('registration', ['state_list' => $state_list,'users_info' => $users_info]);
    }

   /**
    * processing the form data
    *
    * @param Request $request
    * @return mixed
   */
    public function doRegister(RegistrationRequest $request)
    {
        $data = $request->all();

        //perform image upload operation, if image data is present
        if(!empty($data['image']))
        {
            $data[ 'uploaded_image' ] = Helper::imageUpload($request);    
        }
        
        $data['uploaded_image'] = " ";
        $user_id = User::insertUser($data);
        $user_email = $data['email'];
        $user_name = $data['firstname'];

        if($user_id > 0)
        {
           //calling the Generate key function, by passing the user id of user
           $key=Helper::GenerateKey($user_id);

           //Sending mail to user by passing the activation code
           Helper::Email($key, $user_name,$user_email);

           return redirect('/login')->with('status', 'We sent you an activation code. Check your email.');
        }
        else
        {
            //redirect user to registration page with error message
            return redirect('/register')->with('problem', 'Error occured....Try again later.');
        }
    }

   /**
    * Show the login page
    *
    * @param  Request  $request
    * @return mixed
   */
    public function login(Request $request)
    {
        if(!Auth::check())
        {
            return view('login');    
        }
        return redirect('dashboard');
    }

   /**
    * Processing the login page data
    *
    * @param  Request  $request
    * @return mixed
   */
    public function dologin(Request $request)
    {

        //validation message of login page
        $message['email_id.required'] = 'Email id required';
        $message['password.required'] = 'Give your password';

        //validation of email_id and password
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ], $message);
        
        //storing the email_id and password in variable
        $email = $request->email;
        $password = $request->password;

        //Authenticating the requested credential is valid or not
        if (Auth::attempt(['email' => $email, 'password' => $password, 'activated'=>'1'])) 
        {
            //User authenticated, redirect to dashboard
            return redirect('/dashboard');  
        }
        else 
        {
            return redirect('/login')->with('status', 'Invalid email id or password');
        }
    }

    /**
     * Function to perform logout
     *
     * @param Request
     * @return mixed
    */
    public function logout(Request $request)
    {
        // Logging out the user
        Auth::logout();
        Session::flush();

        // After successful logout, redirect user to login page
        return redirect('login');
    }

   /**
    * Function to activate user account
    *
    * @param: activation key
    * @return mixed
    */
   public function activateAccount($token)
   {
        
        $account_status = Helper::activateUser($token);

        if(1 == $account_status)
        {
            //after successful account activation, redirect user to login page
            return redirect('login')->with('status', 'your email is verified, please login to access your account.');
        }    
        else
        {
            return redirect('login');
        }    
   }
}