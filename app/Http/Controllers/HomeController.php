<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Communication;
use App\Http\Requests;
use DB;

class HomeController extends Controller
{
    public function getlist()
    {
    	$get_user = DB::table('users')
    	              ->join('addresses', 'users.id', '=', 'addresses.user_id')
                      ->join('communications','users.id', '=', 'communications.user_id')
                      ->groupBy('users.id')
                      ->get();
            //->leftJoin('communications', 'users.id', '=', 'communications.user_id')
            
    	
       	$information = $get_user;
        //dd($information);
    	return view('list',compact('information'));
    }
}
