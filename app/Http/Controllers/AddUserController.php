<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_activation;
use DB;
use Mail;
use Auth;

/**
 * New user added by Admin
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class AddUserController extends Controller
{
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
    		return view('newUser');
    	}
    }

    /**
	 * Function to register new user
	 *
	 * @param:Request $request
	 * @return: mixed
    */
    public function add_user(Request $request)
    {
    	
    	$auth_obj = new AuthController();
    	
    	$auth_obj->validateRequest($request);

    	$user_data = $request->all();

    	//inserting the user information
		$newuser = User::insertUser($user_data);

		//if insertion is successful, process further
		if($newuser > 0)
		{
			$generated_code = $auth_obj->GenerateKey($newuser);

			$auth_obj->Email($generated_code);

			return redirect('/login')->with('status', 'We sent you an activation code. Check your email.');
        }
        else
        {
            return redirect('/login')->with('warning', 'Error occured, Try again later');
        }
    }
}