<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests;

/**
 * Manages the Google map api request
*/
class MapController extends Controller
{
    /**
     * Function to give location of current user
     *
     * @param request
     * @return view
    */
    public function map(Request $request)
    {   
        $user_id = $request['user'];

        $residence = User::leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
            ->where('users.id', $user_id)
            ->where('addresses.type', 'office')
            ->select('users.id as userId', 'first_name', 'last_name', 'street', 'city', 'state')
            ->get()
            ->toArray();
        
        $office = User::leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
            ->where('user_id', $user_id)
            ->where('addresses.type', 'residence')
            ->select('street as office_street', 'city as office_city', 'state as office_state')
            ->get()->toArray();

        //default resource for unauthenticate user
        $resource = redirect('login');
        if(Auth::check())
        {
            //return view to logged in user
            $resource = view('map')->with(['residence'=> $residence, 'office'=> $office]);
        }
        
        return $resource;
    }
}