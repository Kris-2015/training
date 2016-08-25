<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mail;
use Log;
use Exception;
use App\Models\UserActivation;

/**
 * Helper Model class
 * @access public
 * @package App\Models
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */
class Helper extends Model
{

    /**
     * Function to upload the image
     *
     * @param Request
     * @return image name
    */
    public static function imageUpload($request)
    {
        try
        {
            //fetch the extension of image
            $image_extension = $request->file('image')->getClientOriginalExtension();

            //encrypted name for image
            $image_new_name = md5(microtime(true));
            $image = strtolower($image_new_name . '.' .$image_extension);

            //transferring the image from temporary folder to permanent folder
            $request->file('image')->move( public_path( '/upload') , $image );
            $name = strtolower($image_new_name . '.' .$image_extension);

            if(!empty($name))
            {
                //returning the name of image 
                return $name;    
            }
            else
            {
                throw new Exception("Failed to upload image");
            
            }       
        }
        catch(Exception $e)
        {
            //Log error about failed upload operation
            Log::error($e);
            return 0;
        }
         
    }

    /**
     * Function to send message
     *
     * @param: activation key
     * @return: void
    */
    public static function email($key, $name, $email, $subject='Activate Account', $resource)
    {
        
        $user = array(
            'name' => $name,
            'email' => $email,
            'subject' => $subject
        );

        Mail::queue( " emails.$resource ", ['key'=> $key], function ($m) use ($user)
        {
            $m->from(env('MAIL_FROM'), 'Employee Management Team');

            $m->to($user['email'], $user['name'])->subject($user['subject']);
        });
     }

     /**
     * Generate key 
     * Generate random key for activating the account
     *
     * @param: user id
     * @return: hash 
    */
    public static function generateKey($id)
    {
        try
        {

            $user = new User();
            $get_user = $user::where('id',$id)->get();
            
            $id = $get_user[0]['id'];
            $name = $get_user[0]['first_name'];
            $key = md5($id.$name);

            $data = array('user_id'=>$id, 'token'=>$key);
            $insert_code = UserActivation::insertActivation($data);

            if($insert_code > 0)
            {
                return $key;    
            }

            throw new Exception("Failed to generate key");       
        }
        catch(Exception $e)
        {
            Log::error($e);
        }
    }

    /**
     * Function to activate the users account
     *
     * @param: token number
     * @return: login page with message
    */
    public static function activateUser($token)
    {
        try
        {

            $verify = UserActivation::where('token',$token)->get();
            $user_id = $verify[0]['user_id'];

            if($verify[0]['token'] == $token)
            {
                //update the users table column actiavted to 1
                $user = User::find($user_id);
                $user->activated = '1';
                $user->save();

                return 1;
            }
            
            throw new Exception("Failed to activate user account");
        }
        catch(Exception $e)
        {

            Log::error($e);

            return 0;
        }
    }
}
