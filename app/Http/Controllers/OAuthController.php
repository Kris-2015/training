<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
/**
  * Controller to manage request for oauth restful services
  * 
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
    	dd('hi');
        return User::all();
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
}
