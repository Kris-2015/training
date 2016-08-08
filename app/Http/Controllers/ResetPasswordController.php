<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_activation;
use DB;
use Mail;
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
    public function sendLink(Request $request)
    {
    	return view('resetPassword');
    }

    public function reset(Request $request)
    {	
        $get_request = $request->all();
        $email = $get_request['email'];
    	
    	$user= User::where('email',$email)->get();
        
        if($email == $user[0]['email'])
        {

            $id= $user[0]['id'];
            $newkey = AuthController::GenerateKey($id);
            $this->PasswordResetMail($newkey);

            return redirect('/login')->with('status', 'We sent you an reset password link. Check your email.');
        }
    }

    /**
     * Function to send message
     *
     * @param: password reset link
     * @return: void
    */
	public function PasswordResetMail($key)
     {
     	$user = [
     	'name' => 'kris',
     	'email' => 'krishnadev.rnc@gmail.com'
     	];
     	
     	Mail::queue('emails.reset', ['key'=> $key], function ($m) use ($user)
     	{
     		$m->from('kris@app.com', 'Reset Password');

     		$m->to($user['email'], $user['name'])->subject('Reset Password');
     	});
     }

    /**
     * Function to activate the users account
     *
     * @param: token number
     * @return: login page with message
    */
    public function PasswordPage($token)
    {
        $verify = new user_activation();

        $verify = $verify::where('token',$token)->get();
        $user_id = $verify[0]['user_id'];

        if($verify[0]['token'] == $token)
        {
            return view('changepassword');
        }
    }

    public function updatepassword(Request $request)
    {
        try
        {
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
                throw new \Exception( 'Could not change. Change Password Failed' );
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
