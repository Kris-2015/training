<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserActivation;
use App\MOdels\Helper;
use App\Http\Requests;


/**
 * Manage request for resetting password
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */

class ResetPasswordController extends Controller
{

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

            //subject of the mail
            $subject = 'Reset Mail';
            $newkey = Helper::generateKey($id);

            Helper::email($newkey, $user_name, $email, $subject);

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
            Log::error($e);
            return redirect('/login')->with('status','Error occured, try again later');
        }
    }
}
