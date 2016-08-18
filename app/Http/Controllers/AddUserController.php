<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Helper;
use App\Models\UserActivation;
use Auth;
use App\Http\Requests\RegistrationRequest;

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
            return view('new_user');
        }
    }

    /**
     * Function to register new user
     *
     * @param:Request $request
     * @return: mixed
    */
    public function add_user(RegistrationRequest $request)
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

            //mail the generated code to user
            Helper::Email($generated_code);

            return redirect('/login')->with('status', 'We sent you an activation code. Check your email.');
        }
        else
        {
            return redirect('/login')->with('warning', 'Error occured, Try again later');
        }
    }
}