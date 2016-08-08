<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Communication;
use App\Http\Requests;
use DB;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Manage request dashboard and list
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */

class HomeController extends Controller
{

   /**
    * Function to return dashboard view
    *
    * @param Request
    * @return mixed
    */
    public function dashboard(Request $request)
    {
        //checking if user is logged in
        if (Auth::check())
        {
            return view('dashboard');    
        }
        else
        {
            return redirect('login');
        }
        
    }

    /**
      * Function to get information of user
      *
      * @param void
      * @return mixed
    */
    public function getlist()
    {
        //storing users information
        $information = $this->UserInformation();

        //returning the users information with list blade file
        return view('list',compact('information'));
    }

    /**
     * Function to get all the data by user id
     *
     * @param: integer
     * @return: void
    */
    public function Data($id)
    {
        //storing the state list in array
        $state_list = config('constants.state_list');
        $users_info = $this->UserInformation();

        return view("registration",compact('users_info','state_list'));
        
    }

   /**
     * Function to delete the user
     *
     * @param: id
     * @return redirect
    */
    public function delete(Request $request)
    {
        try
        {   
            //fetching the user id from request variable
            $id = $request['id'];

            //performing delete operation
            User::destroy($id);

            return 1;
        }
        catch(Exception $e)
        {
            return 0;
        }
    }

    /**
     * Function to fetch all the users information 
     *
     * @param: void
     * @return: array
    */
    public function UserInformation()
    {

        $get_user = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                    ->join('communications','users.id', '=', 'communications.user_id')
                    ->groupBy('users.id');
            
        
        $information_residence = $get_user->where('addresses.type', 'residence')
                    ->get()->toArray();

        $information_office = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                    ->select( 
                        "addresses.street AS office_street",
                        "addresses.city AS office_city",
                        "addresses.state AS office_state",
                        "addresses.zip AS office_zip",
                        "addresses.mobile AS office_mobile",
                        "addresses.landline AS office_landline",
                        "addresses.fax AS office_fax"
                    )->groupBy('users.id')->where('addresses.type', 'office')
                    ->get()->toArray();
        
        $information = array();

        foreach ($information_residence as $key => $residence)
        {
            
            $office = $information_office[$key];
            $information[$key] = $residence + $office;
        }

        return $information;
    }
}