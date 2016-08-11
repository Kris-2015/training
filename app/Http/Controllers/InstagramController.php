<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Instagram;
use App\Http\Requests;
use App\Models\User;
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
    //taking a protected variable of instagram
    protected $instagram;


    public function __construct(InstagramManager $instagram)
    {
        $this->instagram = $instagram;
    }

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
        dd($server_response_json->{'user'});
        $this->homePage($server_response_json);
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
        $user_id = $user->id;
        $user_fullname = explode(" ",$user->{'full_name'});
        $first_name = $user_fullname[0];
        $last_name = $user_fullname[1];

        $insta_userdata = array(
            $username,
            $first_name,
            $last_name,
            $user_id
        );
         
        //$server_response_json->{"access_token"}
   }
}
