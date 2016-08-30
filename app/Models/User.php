<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
/*use Log;*/
use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * User Model class
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;
    use SoftDeletes;
    protected $fillable = ['id', 'first_name'];
    protected $dates = ['deleted_at'];

    /**
     * Get the address of the user
    */
    public function address()
    {
        return $this->hasMany('App\Models\Address');
    }
    /*
     * store the information in users table
     * @param Request
     * 
     * @return boolean
    */
   public static function insertUser($data)
   {
    
        try 
        {

            DB::beginTransaction();
            $user = new User;
            $password = bcrypt($data['password']);

            $user->first_name = isset( $data['firstname'] ) ? $data['firstname'] : '';
            $user->middle_name = isset( $data['middlename'] ) ? $data['middlename'] : '';
            $user->last_name = isset( $data['lastname'] ) ? $data['lastname'] : '';
            $user->prefix = isset( $data['prefix'] ) ? $data['prefix'] : '';
            $user->gender = isset( $data['gender'] ) ? $data['gender'] : '';
            $user->dob = isset( $data['dob'] ) ? $data['dob'] : '';
            $user->marital_status = isset( $data['marital_status'] ) ? $data['marital_status'] : '';
            $user->employment = isset( $data['employment'] ) ? $data['employment'] : '';
            $user->employer = isset( $data['employer'] ) ? $data['employer'] : '';
            $user->email = $data['email'];
            $user->github_id = isset( $data['githubid'] ) ? $data['githubid'] : '';
            $user->password = $password; 
            $user->image = isset( $data['uploaded_image'] ) ? $data['uploaded_image'] : '';
            $success = $user->save();

            $user->first_name = isset($data['firstname']) ? $data['firstname'] : '' ;

            $user->middle_name = isset($data['middlename']) ? $data['middlename'] : '' ;

            $user->last_name = isset($data['lastname']) ? $data['lastname'] : '' ;

            $user->prefix = isset($data['prefix']) ? $data['prefix'] : '' ;

            $user->gender = isset($data['gender']) ? $data['gender'] : '' ;

            $user->dob = isset($data['dob']) ? $data['dob'] : '' ;

            $user->marital_status = isset($data['marital_status']) ? $data['marital_status'] : '' ;

            $user->employment = isset($data['employment']) ? $data['employment'] : '' ;

            $user->employer = isset($data['employer']) ? $data['employer'] : '' ;

            $user->email = isset($data['email']) ? $data['email'] : '' ;

            $user->github_id = isset($data['githubid']) ? $data['githubid'] : '' ;

            $user->password = $password; 

            $user->image = isset($data['uploaded_image']) ? $data['uploaded_image'] : '' ;
            $success = $user->save(); 

            $data['user_id'] = $user->id;

            if($success)
            {
                $address_success = Address::insertAddress($data);

                if($address_success === 1)
                {
                    $comm_success = Communication::insertCommunication($data);

                    if($comm_success === 0)
                    {
                        throw new \Exception( 'Could not sign up. Comm Failed.' );
                    }
                }
                else
                {
                    throw new \Exception( 'Could not sign up. Address Failed.' );
                }
            }
            else
            {
                throw new \Exception( 'Could not sign up. User Failed' );
            }

            DB::commit();
            return $data['user_id'];
        }
        catch (\Exception $e) 
        {
            //logging the error in log file
            errorReporting($e);
            DB::rollBack();
            return 0;
        } 
        return 1;
   } 

   /**
    * Function to change the user account status
    *
    * @param id
    * @return integer
   */
   public static function changeStatus($id)
   {
       try
       {
        
            $user = User::withTrashed()->find($id);
            $user->deleted_at = NULL;

            $changed_status = $user->save();

            if($changed_status == 1)
            {
                //return 1 on deactivating the user account
                return 1;
            }

            throw new Exception("Error: Failed to change the user account status");
       }
       catch(Exception $e)
       {
            errorReporting($e);

            //return 0 as failed to change the status of user account
            return 0;
       }
   }

  /**
    * Function to perform insertion for Intagram user
    *
    * @param: basic user_info
    * @return: integer
   */
   public static function instagaramUser($data)
   {
        try
        {
            $user_id = 0;
            $insta_user = new User();

            $insta_user->first_name = $data['first_name'];
            $insta_user->last_name = $data['last_name'];
            $insta_user->instagram_id = $data['instagram_id'];
            $insta_user->instagram_username = $data['username'];

            $insta_user->save();
            $user_id = $insta_user->id;

            if($user_id != 0)
            {
                return $user_id;    
            }
            else
            {
                throw new Exception("Error occured while instagram sign-up");
            }
        }
        catch (Exception $e)
        {

            errorReporting($e);
            return 0;
        }
   }

   /**
    * Function to insert information of facebook user
    *
    * @param array
    * @return integer
   */
   public static function facebookUser($fb)
   {
        try
        {
            //perform the insertion of facebook data
            $fb_user = new User();

            $user_id = 0;
            
            $fb_user->first_name = $fb['first_name'];
            $fb_user->last_name = $fb['last_name'];
            $fb_user->gender = $fb['gender'];
            $fb_user->email = $fb['email'];
            $fb_user->facebook_id = $fb['facebook_userid'];

            $fb_user->save();
            $user_id = $fb_user->id;
            
            if($user_id != 0)
            {
                return $user_id;    
            }
            else
            {
                throw new Exception("Error occured while instagram sign-up");
            }
        }
        catch(Exception $e)
        {
            errorReporting($e);
        }
   }