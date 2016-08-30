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
 * @author mfsi-krishnadev
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
            $comm_list = isset( $data['communication'] ) ? implode(',', $data['communication']) : '';
            $comm->user_id = $data['user_id'];
            $comm->type = $comm_list;
            $communication_success = $comm->save();

            if($communication_success)
            {
                return 1;
            }
            else
            {
                throw new \Exception ( 'Error: error occured while inserting in communication table' );
            }
        }
        catch (\Exception $e) 
        {
            //logging the error in log file
            errorReporting($e);
            return 0;
        } 
    }
}
