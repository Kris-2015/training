<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class user_activation extends Model
{
    public static function insertActivation($data)
    {
    	try
    	{
    	   DB::beginTransaction();
           $insert_activation_code = new user_activation();
           
           $insert_activation_code->user_id = $data['user_id'];
           $insert_activation_code->token = $data['token'];
           $insert_activation_code->save();

           DB::commit();
           return 1;
    	}
    	catch(Exception $e)
    	{
            Log::error($e);
            DB::rollback();
    	}
    }

}
