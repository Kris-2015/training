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

    /**
     * Get the address that beongs to user
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

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

                'street' => isset( $data['homestreet'] ) ? $data['homestreet'] : '',
                'city' => isset( $data['homecity'] ) ? $data['homecity'] : '',
                'state' => isset( $data['homestate'] ) ? $data['homestate'] : '',
                'zip' => isset( $data['homezip'] ) ? $data['homezip'] : '',
                'mobile' => isset( $data['homemobile'] ) ? $data['homemobile'] : '',
                'landline' => isset( $data['homelandline'] ) ? $data['homelandline'] : '',
                'fax' => isset( $data['homefax'] ) ? $data['homefax'] : '',
                'updated_at' => date( 'Y-m-d H:i:s' ),
                'created_at' => date( 'Y-m-d H:i:s' )
            ];

            $office_add = [
                'user_id' => $data['user_id'],
                'type' => "office",
                'street' => isset($data['officestreet']) ? $data['officestreet'] : '',
                'city' => isset($data['officecity']) ? $data['officecity'] : '',
                'state' => isset($data['officestate']) ? $data['officestate'] : '',
                'zip' => isset($data['officezip']) ? $data['officezip'] : '',
                'mobile' => isset($data['officemobile']) ? $data['officemobile'] : '',
                'landline' => isset($data['officelandline']) ? $data['officelandline'] : '',
                'fax' => isset($data['officefax']) ? $data['officefax'] : '',
                'updated_at' => date( 'Y-m-d H:i:s' ),
                'created_at' => date( 'Y-m-d H:i:s' )
            ];

            Address::insert( [ $residence_add, $office_add ] );

            return 1;
        }
        catch (\Exception $e) 
        {
            //logging the error in log file
            errorReporting($e);
            return 0;
        } 
   }

    /*
     * Function to update address table
     * @param address data
     * 
     * @return boolean
    */
   public static function updateAddress($data)
   {
        try 
        {
            $update_residence = Address::where('user_id', $data['id'])
                ->where('type', '=', 'residence')
                ->update([
                        'street' => $data['homestreet'],
                        'city' => $data['homecity'],
                        'state' => $data['homestate'],
                        'zip' => $data['homezip'],
                        'mobile' => $data['homemobile'],
                        'landline' => $data['homelandline'],
                        'fax' => $data['homefax'],
                        'updated_at' => date( 'Y-m-d H:i:s' ),
                        'created_at' => date( 'Y-m-d H:i:s' )
                    ]);

            $update_office = Address::where('user_id', $data['id'])
                ->where('type', '=', 'office')
                ->update([
                        'street' => $data['officestreet'],
                        'city' => $data['officecity'],
                        'state' => $data['officestate'],
                        'zip' => $data['officezip'],
                        'mobile' => $data['officemobile'],
                        'landline' => $data['officelandline'],
                        'fax' => $data['officefax'],
                        'updated_at' => date( 'Y-m-d H:i:s' ),
                        'created_at' => date( 'Y-m-d H:i:s' )
                    ]);
            return 1;
        }
        catch (\Exception $e) 
        {
            //logging the error in log file
            errorReporting($e);
            return 0;
        } 
   }
}
