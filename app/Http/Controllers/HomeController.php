<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Communication;
use App\Http\Requests;
use App\Models\Helper;
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
            //return user to dashboard
            $page = view('dashboard');    
        }
        
        //redirect new user to login page
        $page = redirect('login');

        return $page;
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
        $information = Helper::UserInformation();

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
        $users_info = Helper::UserInformation($id);

        //checking user_info contain some data
        if(!empty($users_info))
        {   
            $view = view("registration",['state_list' => $state_list,'users_info' => $users_info]);
        }
        
        //return view if user_data is empty
        $view = view("registration",['state_list' => $state_list,'users_info' => NULL]);
         
        return $view; 
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
}