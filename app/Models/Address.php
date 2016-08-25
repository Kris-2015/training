<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

/**
 * Address Model class
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class Address extends Model
{
    /*
     * store the information in address table
     * @param address data
     * 
     * @return boolean
    */
   public static function insertAddress($data)
   {
        try 
        {
            $residence_add = [
                'user_id' => $data['user_id'],
                'type' => "residence",
                'street' => $data['homestreet'],
                'city' => $data['homecity'],
                'state' => $data['homestate'],
                'zip' => $data['homezip'],
                'mobile' => $data['homemobile'],
                'landline' => $data['homelandline'],
                'fax' => $data['homefax'],
                'updated_at' => date( 'Y-m-d H:i:s' ),
                'created_at' => date( 'Y-m-d H:i:s' )
            ];

            $office_add = [
                'user_id' => $data['user_id'],
                'type' => "office",
                'street' => $data['officestreet'],
                'city' => $data['officecity'],
                'state' => $data['officestate'],
                'zip' => $data['officezip'],
                'mobile' => $data['officemobile'],
                'landline' => $data['officelandline'],
                'fax' => $data['officefax'],
                'updated_at' => date( 'Y-m-d H:i:s' ),
                'created_at' => date( 'Y-m-d H:i:s' )
            ];

            Address::insert( [ $residence_add, $office_add ] );

            return 1;
        }
        catch (\Exception $e) 
        {
            //logging the error in log file
            Log::error($e);
            return 0;
        } 
   }
}
