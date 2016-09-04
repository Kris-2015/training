<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use Socialite;
use Auth;

/**
 * Manage request dashboard and list information
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */

class SocialAuthController extends Controller
{
   /**
    * Function to get facebook driver
    *
    * @param void
    * @return mixed 
    */
   public function redirect()
   {
        return Socialite::driver('facebook')->redirect();
   }

  /**
    * Function to return back the callback by facebook
    * 
    * @param:
    * @return:
   */
  public function callback()
  {
        // Storing the data given by facebook api
        $providedUser = \Socialite::driver('facebook')->user();
        $facebook_userid = $providedUser->id;
        $facebook_gender = $providedUser->user['gender'];
        $facebook_email = $providedUser->email;
        $facebook_name = explode(' ',$providedUser->name);
        $user_firstname = $facebook_name[0];
        $user_lastname = $facebook_name[1];

        //assuming there is no new facebook user yet
        $new_fbuser = 0;    
        $user_id = User::where('facebook_id', $facebook_userid)->value('id');
        
        if( $user_id == NULL )
        {

            // Collecting all the data in an array
            $facebook_user = array(
                "facebook_userid" => $facebook_userid,
                "gender" => $facebook_gender,
                "email" => $facebook_email,
                "first_name" => $user_firstname,
                "last_name" => $user_lastname
            );

            $user_id = User::FacebookUser($facebook_user);

            $new_fbuser = 1;
        }

        if( Auth::loginUsingId($user_id) )
        {
            //if user already exist
            if( $new_fbuser != 1)
            {
                //redirect user to dashboard
                return redirect('dashboard');
            }

            //if the user is new, request user to update profile info
            return redirect('register/' . $user_id)->with('new', 'Please Update your profile');
        }
        else
        {
            //if login operation failed, direct the user to login page
            return redirect('login')->with('warning', 'Something went wrong.');
        }

  }
}
