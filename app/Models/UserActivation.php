dd<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;


/**
 * UserActivation Model class
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */
class UserActivation extends Model
{
   /*

    */
    public static function insertActivation($data)
    {
        try
        {
             DB::beginTransaction();
             $insert_activation_code = new UserActivation();
           
             $insert_activation_code->user_id = $data['user_id'];
             $insert_activation_code->token = $data['token'];

             $sucess_insertcode = $insert_activation_code->save();

             if($sucess_insertcode == 1)
             {
                DB::commit();
                return 1;
             }

             throw new Exception("Error: Failed to process activation key");
        }
        catch(Exception $e)
        {
            //Log error about the failing of activation key insertion
            Log::error($e);
            DB::rollback();
        }
    }
    
}
