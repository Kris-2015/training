<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\OAuthClient;
use App\Models\OAuthAccessToken;
use App\Models\OAuthRefreshToken;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;

/**
 * Controller to manage request for oauth restful services
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
*/

class OAuthController extends Controller
{

    
	/**
	 * Function to get all user
	 *
	 * @param: Request
	 * @return: json
	*/
    public function index(Request $result)
    {
        // Validating the token
        $user_token = $this->authenticateToken($result['token']);
        
        // Default data
        $data = response()->json(array('error' => '404', 'message' => 'Insufficient Parameter'), 404);

        // If token is authenticated, then return required data
        if ( $user_token )
        {   
            $user_data = User::select('first_name', 'middle_name', 'last_name', 'dob', 'email')
                ->get();

            $data = array(
                'access_token' => $result['token'],
                'user' => $user_data 
            );
        }

        return $data;
    }

    /**
	 * Function to search user by id
	 *
	 * @param: user id
	 * @return: json
    */
    public function show($id) 
    {   
        $userby_id = User::find($id);
        
        // Checking the userby id is returning any data
        if ( is_null($userby_id) )
        {
            return response()->json(array('error' => '404', 'message' => 'Not Found'), 404);
        }

    	return $userby_id;
    }

    /*
     * Generate access token
    */
    public function accessToken(Request $request)
    {   
        
        // Calling function to authenticate the client request
        $client_request = $this->authenticateClient($request->all());
        
        // Condition for invalid user.
        if ( $client_request->isEmpty() )
        {
            return response()->json(array('error' => '404', 'message' => 'Requested client does not exist'), 404); 
        }

        // Checking if client has been issued token before
        $check_client = OAuthAccessToken::where('oauth_client_id', $client_request[0]['id'])
            ->get();        
        // Create token for new user
        if ( $check_client->isEmpty() )
        {   
            // Get the auto genrated token
            $token = token();
            
            // Registering the token with the client serial number
            $token_data = array(
                'serial_no' => $client_request[0]['id'],
                'token' => $token
            );

            // Updating the database with new records
            $token_id = OAuthAccessToken::insertToken($token_data);

            // Life of the generated token
            $access_token_ttl = 60;

            // Get the unix timestap constant 
            $present_time = time();

            // Expire time of the token
            $expire_time = $present_time + $access_token_ttl;

            // Data of the token life span
            $lifespan = array(
                'access_token_id' => $token_id,
                'token_life' => $access_token_ttl,
                'expire_time' => $expire_time
            );


            // Update the token details with its life span and expiration time
            $token_details = OAuthRefreshToken::insertDetails($lifespan);

            // If insert record is not empty
            if ( $token_details )
            {
                $arr = array(
                'token' => $token 
                );

                return response()->json($arr);    
            }

            return response()->json(array('error' => '400', 'message' => 'Bad Request'), 404);
        }

        // If the client is already registered 
        else if ( $check_client->isEmpty() )
        {
            // return the assigned token
            return array('token' => $check_client[0]['token']);
        }   
    }

    /**
     * Function to Authenticate Client
     *
     * @param: client id
     * @param: client secret
     * @param: redirect
     *
     * @return: array
    */
    public function authenticateClient($client)
    {
        $client_id = isset($client['client_id']) ? $client['client_id'] : '';
        $client_secret = isset($client['client_secret']) ? $client['client_secret'] : '';
        $redirect = isset($client['redirect']) ? $client['redirect'] : '';

        // Validating the client id , client secret id and redirect url
        $valid = OAuthClient::where('client_id', $client_id)
            ->where('secret', $client_secret)
            ->where('callback', $redirect)
            ->get();

        return $valid;
    }

    /**
     * Function to authenticate token
     * 
     * @param: token
     * @return: integer 
    */
    public function authenticateToken($token)
    {
        // Validate with the user's token
        $validate_token = OAuthAccessToken::where('token', $token)
            ->get();
        
        // Condition to check users token has matched with server token
        if ( $validate_token->isEmpty() )
        {
            return 0;
        }

        return 1;
    }
}