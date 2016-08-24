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
 * Manage request dashboard and list information
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
        $information = $this->userInformation();

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

        if(Auth::user()->role_id == '2' &&  Auth::user()->id != $id) 
        {
            return redirect('dashboard')->with('access','Not authorised');
        }    

        //storing the state list in array
        $state_list = config('constants.state_list');
        $users_info = $this->userInformation($id);

        if(!empty($users_info))
        {   
            return view("registration",['state_list' => $state_list,'users_info' => $users_info]);       
        }
        else
        {   
            $users_info = NULL;
            return view("registration",['state_list' => $state_list,'users_info' => $users_info]);
        }
          
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
     * Function to fetch all the information of user 
     *
     * @param: id
     * @return: array
    */
    public function userInformation($id=false)
    {
        //get the information of user by user id
        if($id)
        {
            $get_user = User::find($id)->join('addresses', 'users.id', '=', 'addresses.user_id')
                ->join('communications','users.id', '=', 'communications.user_id')
                ->groupBy('users.id');      
        }
        else
        {
            //get all the information of all user 
            $get_user = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                ->join('communications','users.id', '=', 'communications.user_id')
                ->groupBy('users.id');
        }

        //get the residence address of user of user
        $information_residence = $get_user->where([ ['addresses.type', 'residence'],
                 ['addresses.user_id', '=', $id] ])
               ->get()->toArray();

        //get the office address of user of user
        $information_office = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                ->select( 
                    "addresses.street AS office_street",
                    "addresses.city AS office_city",
                    "addresses.state AS office_state",
                    "addresses.zip AS office_zip",
                    "addresses.mobile AS office_mobile",
                    "addresses.landline AS office_landline",
                    "addresses.fax AS office_fax"
                )->groupBy('users.id')->where([ ['addresses.type', 'office'], 
                    ['addresses.user_id', '=', $id] ])
                ->get()->toArray();
        
        //array to store the all the information of user
        $information = array();

        //loop to concat the residence and office information of user
        foreach ($information_residence as $key => $residence)
        {
            
            $office = $information_office[$key];
            $information[$key] = $residence + $office;
        }

        //return the complete information of user
        return $information;
    }
}