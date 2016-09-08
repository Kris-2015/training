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
use App\Http\Requests\NewUserRequest;


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
        
        return view('registration', ['state_list' => $state_list, 'route' => 'do-register',
            'users_info' => NULL]);
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
        $data['uploaded_image'] = Helper::imageUpload($request);
        $user_id = User::insertUser($data);
        $user_email = $data['email'];
        $user_name = $data['firstname'];

        if($user_id > 0)
        {
            //calling the Generate key function, by passing the user id of user
            $key=Helper::generateKey($user_id);

            //storing the required data in array
            $account_data = array(
                'activation' => $key,
                'email' => $user_email,
                'username' => $user_name,
                'subject' => 'Account Activation'
            );

            //Sending mail to user by passing the activation code
            Helper::email($account_data, 'activate');

            return redirect('/login')->with('status', 'We sent you an activation code. Check your email.');
        }
        
        //redirect user to registration page with error message
        return redirect('/register')->with('problem', 'Error occured....Try again later.');
    }

    /**
     * Function to Update Information of user
     *
     * @param Request
     * @return redirect
    */
    public function doUpdate(Request $request)
    {
        // Get the required update data
        $update_data = $request->all();

        // Updating the information
        $update_status = User::updateUser($update_data);
        
        // Checking if user information has been successfully updated
        if ($update_status == 1)
        {
            return redirect('dashboard')->with('success', 'Updated the information successfully.');
        }

        return redirect('dashboard')->with('access', 'Some problem occured...Try again later.');
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
        
        return redirect('/login')->with('warning', 'Invalid email id or password');
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
        // checking the given token is authenticate or not
        $account_status = Helper::activateUser($token);

        if(1 == $account_status)
        {
            //after successful account activation, redirect user to login page
            return redirect('login')->with('status', 'your email is verified, please login to access your account.');
        }    
        
        return redirect('login');   
   }

   /**
     * Function will activate the user account
     *
     * @param: $user_id
     * @return: json
    */
    public function activateUser(Request $request)
    {
        //user id for activating user account
        $user_id = $request['id'];

        //changing the status of user account
        $active = User::changeStatus($user_id);

        //returning the activate message to show 'activate' account
        return response()->json('activate');
    }

    /**
     * Function to return the view of reset password page
     *
     * @param: incoming request
     * @return: reset password page
    */
    public function sendLink(Request $request)
    {
        return view('resetpassword');
    }

    /**
    * Function to sent the link of reset password
    *
    * @param: incoming request
    * @return: mixed
    */
    public function reset(Request $request)
    {   

        $get_request = $request->all();
        $email = $get_request['email'];
        
        $user= User::where('email',$email)->get();
        
        
        if ( $user->count()  == 0)
        {
            return redirect('/login')->with('warning', 'Invalid email id.');
        }
        else
        {
            //get user id
            $id = $user[0]['id'];
           
            //get first name of user
            $user_name = $user[0]['first_name'];

            $newkey = Helper::generateKey($id);

            //storing the required data in array
            $mail_data = array(
                  'activation' => $newkey,
                  'email' => $email,
                  'username' => $user_name,
                  'subject' => 'Reset Mail'
                );

            Helper::email($data, 'reset');

            return redirect('/login')->with('status', 'We sent you an reset password link. Check your email.');
        }
    }

    /**
     * Function to return change password page after token matching
     *
     * @param: token number
     * @return: change password page
    */
    public function passwordPage($token)
    {
        $verify = UserActivation::where('token',$token)->get();

        if($verify[0]['token'] == $token)
        {
            return view('changepassword');
        }
    }

   /**
    * Function to update with new password
    *
    * @param: incoming request
    * @return: mixed
   */
    public function updatePassword(Request $request)
    {
        try
        {
            //store required information from request variable
            $credential = $request->all();
            $email_id = $credential['email'];
            $password = $credential['password'];
            $cpassword = $credential['cpassword'];

            if($password == $cpassword)
            {
                
                $new_password = bcrypt($password);
                $user = User::where('email',$email_id)->first();
                $user->password = $new_password;
                $user->save();

                return redirect('/login')->with('status', 'Password changed !!!');    
            }   
            else
            {
                throw new Exception( 'Could not change. Change Password Failed' );
            }         
        }
        catch(Exception $e)
        {
            //logging the error into log file
            errorReporting($e);
            return redirect('/login')->with('status','Error occured, try again later');
        }
    }

   /**
    *Function to show Add New User Page
    *
    * @param: incoming request
    * @return: mixed
   */
    public function newUser(Request $request)
    {
        if(Auth::user()->role_id == 1)
        {
            return view('newuser');
        }
    }

    /**
     * Function to register new user
     *
     * @param:Request $request
     * @return: mixed
    */
    public function addUser(NewUserRequest $request)
    {
        //Collects all the users detail
        $user_data = $request->all();

        //inserting the user information
        $new_user = User::insertUser($user_data);

        //if insertion is successful, process further
        if($new_user > 0)
        {
            //get the generated code
            $generated_code = Helper::GenerateKey($new_user);
            $new_email = $user_data['email'];
            $new_name = $user_data['firstname'];
            $password = $user_data['password'];
            
            //storing the required data in array
            $email_data = array(
                  'activation' => $generated_code,
                  'email' => $new_email,
                  'username' => $new_name,
                  'password' => $password,
                  'subject' => 'Account Activation'
                );

            //mail the generated code to user
            Helper::email($email_data, 'new');

            return redirect('/dashboard')->with('message', 'Added new user successfully.');
        }
        
        return redirect('/login')->with('message', 'Error occured, Try again later');
    }    
}