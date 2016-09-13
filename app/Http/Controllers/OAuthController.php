<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\OAuthClient;
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
        $email = $result['email'];
        $password  = $result['password'];

        if ( ! Auth::once(['email' => $result->email, 'password' => $result->password, 'activated'=>'1']) )
        {
            return array('error' => '404', 'message' => 'Unauthorised User');
        }

        $token = $result['token'];

        $data = array('error' => '404', 'message' => 'Required result not found');

        if ( !empty($result['token']) )
        {
            $data = User::all();    
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
    	return User::findOrFail($id);
    }
    /*
     * Generate access token
    */
    public function accessToken(Request $request)
    {
        $client_request = $this->authenticateClient($request->all());

        if( empty($client_request) )
        {
            return array('erro$result->all()r' => '404', 'message' => 'Requested client does not exist');
        }

        $arr = array(
            'token' => token() 
        );
        return response()->json($arr);   
    }

    /**/
    public function authenticateClient($client)
    {
        $client_id = $client['client_id'];
        $client_secret = $client['client_secret'];

        $valid = OAuthClient::where('id', $client_id)
            ->where('secret', $client_secret)
            ->get();

        return $valid;
    }
}
