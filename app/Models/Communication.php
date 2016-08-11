<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;


/**
 * Communication Model class
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author vivek
 * @link void
 */
class Communication extends Model
{
   /*
	 * store the information in communication table
	 * @param Request
	 * 
	 * @return boolean
	*/
   public static function insertCommunication($data)
   {
        try 
        {
        	$comm = new Communication;
            $comm_list = implode(',', $data['communication']);
            $comm->user_id = $data['user_id'];
            $comm->type = $comm_list;
            $communication_success = $comm->save();

            if($communication_success)
            {
                return 1;
            }
            else
            {
                throw new \Exception ( 'Bad' );
            }
        }
        catch (\Exception $e) 
        {
        	//logging the error in log file
        	Log::error($e);
            return 0;
        } 
   }
}
