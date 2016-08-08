<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests;

/**
 * Activate the user account
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class ActivateUserController extends Controller
{
  /**
	* Function will activate the user account
	*
	* @param: $user_id
	* @return: 
    */
    public function activateUser(Request $request)
    {
        $user_id = $request['id'];
        $active = User::changeStatus($user_id);

        echo json_encode('activate');
    }
}
