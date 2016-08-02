<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Communication;
use App\Http\Requests;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeController extends Controller
{
    public function getlist()
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
        foreach($information_residence as $key=>$val){ // Loop though one array
            $val2 = $information_office[$key]; // Get the values from the other array
            $information[$key] = $val + $val2; // combine 'em
        }
        return view('list',compact('information'));
    }

    /*
     * Function to get all the data by user id
     *
     * @param: integer
     * @return: none
    */
    public function Data($id)
    {
        $state_list = config('constants.state_list');
        
        $get_user = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                    ->join('communications','users.id', '=', 'communications.user_id')
                    //->groupBy('users.id');
                    ->where('users.id',$id);
        
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
        foreach($information_residence as $key=>$val){ // Loop though one array
            $val2 = $information_office[$key]; // Get the values from the other array
            $information[$key] = $val + $val2; // combine 'em
        }
        //dd($information);
        /*return view("registration",['information' => $information,'state_list' => $state_list ]);*/
        return view("registration",compact('information','state_list'));
        
    }

    /*
     * Function to delete the user
     *
     * @param: id
     * @return redirect
    */

    public function delete(Request $request)
    {
        $id = $request['id'];

        $user = User::find($id);

        $user->isActive = '0';//when user wishes to delete, mark 0 in the isActive column

        $user->save();
    }
}
