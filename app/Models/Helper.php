<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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

        $file_name = '';   

        // Condition to determine if file contains image or not 
        if ($request->hasFile('image'))
        {
            //fetch the extension of image
            $image_extension = $request->file('image')->getClientOriginalExtension();

            //encrypted name for image
            $image_new_name = md5(microtime(true));
            $image = strtolower($image_new_name . '.' .$image_extension);

            //transferring the image from temporary folder to permanent folder
            $move_file = $request->file('image')->move( public_path( 'upload') , $image );
            $file_name = strtolower($image_new_name . '.' .$image_extension);

            try
            {
                // if image upload is not successful
                if( !$move_file )
                {
                    throw new Exception('Failed to upload image.');
                }    
            }
            catch ( \Exception $e)
            {
                //Log error
                errorReporting($e);
            }   
        }
        
        //returning the name of image 
        return $file_name;                
    }

    /**
     * Function to send message
     *
     * @param: activation key
     * @return: void
    */
    public static function email($data, $resource)
    {
        $key = $data['activation'];
        $email = $data['email'];
        $name = $data['username'];
        $subject = $data['subject'];
        $password = isset($data['password']) ? $data['password'] : '';

        $user = array(
            'name' => $name,
            'email' => $email,
            'subject' => $subject
        );

        Mail::queue( " emails.$resource ", ['data'=> $data], function ($m) use ($user)
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

    /**
     * Function to fetch all the information of user 
     *
     * @param: id
     * @return: array
    */
    public static function UserInformation($id=false)
    {
        //get the information of user by user id
        if($id)
        {
            $get_user = User::find($id)->join('addresses', 'users.id', '=', 'addresses.user_id')
                ->join('communications','users.id', '=', 'communications.user_id')
                ->groupBy('users.id');  

            //get the residence address of user
            $information_residence = $get_user->where([ ['addresses.type', 'residence'],
                ['addresses.user_id', '=', $id] ])
               ->select('users.id as userId', 'first_name', 'middle_name', 'last_name', 'prefix', 'gender', 'dob', 'marital_status', 'employer', 'employment', 'email', 'role_id', 'github_id', 'image', 'street', 'city', 'state', 'zip', 'mobile', 'landline', 'fax', 'communications.type')
               ->get()
               ->toArray();
            
            //get the office address of user of user
            $information_office = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                ->select( 
                    "addresses.street AS office_street",
                    "addresses.city AS office_city",
                    "addresses.state AS office_state",
                    "addresses.zip AS office_zip",
                    "addresses.mobile AS office_mobile",
                    "addresses.landline AS office_landline",
                    "addresses.fax AS office_fax"
                )->groupBy('users.id')->where([ ['addresses.type', 'office'], 
                ['addresses.user_id', '=', $id] ])
                ->get()->toArray();
            
            //array to store the all the information of user
            $information = array();

            //loop to concat the residence and office information of user
            foreach ($information_residence as $key => $residence)
            {
                
                $office = $information_office[$key];
                $information[$key] = $residence + $office;
            }
        }
        else
        {
            //get all the information of all user 
            $get_user = User::join('addresses', function ($join){

                $join->on('users.id', '=', 'addresses.user_id')
                    ->where('addresses.type', '=', 'residence');
                })
                ->join('communications','users.id', '=', 'communications.user_id')
                ->groupBy('users.id')
                ->get()
                ->toArray();

            $get_office = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                ->select( 
                    "addresses.street AS office_street",
                    "addresses.city AS office_city",
                    "addresses.state AS office_state",
                    "addresses.zip AS office_zip",
                    "addresses.mobile AS office_mobile",
                    "addresses.landline AS office_landline",
                    "addresses.fax AS office_fax"
                )->groupBy('users.id')
                ->where('addresses.type', '=', 'office')
                ->get()
                ->toArray();

            $information = array();

            foreach($get_user as $key => $residence)
            {
                $office = $get_office[$key];
                $information[$key] = $residence + $office;
            }
        }
        //dd($information);
        //return the complete information of user
        return $information;
    }
}
