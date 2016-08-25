<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Instagram;
use App\Http\Requests;
use App\Models\User;
use Auth;
use Vinkla\Instagram\InstagramManager;

/**
 * Manage request dashboard and list information
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class InstagramController extends Controller
{

    /**
    * Function to interact with Instagram api for user sign up
    *
    * @param: Request
    * @return: json
    */
    public function details(Request $request)
    {
        //get the response code given instagram api
        $code = $request->all()['code'];
        
        //instagram data
        $insta_data = $this->curlInsta();

        return $this->homePage($insta_data);
    } 

   /**
     * Function will redirect after the user information has been noted
     *
     * @param json decode array
     * @return mixed
    */
   public function homePage($data)
   {   
        $access_token = $data->{"access_token"};
        $user = $data->{'user'};
        $username = $user->{'username'};
        $instagram_id = $user->{"id"};
        $user_fullname = explode(" ",$user->{'full_name'});
        $first_name = $user_fullname[0];
        $last_name = isset($user_fullname[1]) ? $user_fullname[1] : '';

        //assuming there is no new user
        $new_user = 0;
        $id = User::where('instagram_username', $username)->value('id');

        //check if the user is present in database
        if(!isset($id))
        {
            //user does not exist, creating a new user
            $insta_userdata = array(
                "access_token" => $access_token,
                "username" => $username,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "instagram_id" => $instagram_id
            );

            $id = User::instagaramUser($insta_userdata);

            //new user has created
            $new_user = 1;
        }

        if( Auth::loginUsingId($id))
        {
            //if user already exist
            if($new_user != 1)
            {
                return redirect('dashboard');
            }

            //if user is new user
            return redirect('register/' . $id)->with('new', 'Please Update your profile');
        }
        
        //if login operation failed, direct the user to login page
        return redirect('login')->with('warning', 'Something went wrong.');
   }

  /**
    * Function to perform curl operation for instagram api
    * 
    * @param void
    * @return json
   */
    private function curlInsta()
    {
        //initialising the curl operation
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://api.instagram.com/oauth/access_token');
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET') ,
            'grant_type' => 'authorization_code',
            'redirect_uri' => env('REDIRECT_URI'),
            'code' => $code
        )));

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_response = curl_exec ($ch);

        $server_response_json = json_decode($server_response);

        curl_close ($ch);

        return $server_response_json;
    }
}