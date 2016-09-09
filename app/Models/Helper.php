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
            
            // Making a new file name
            $file_name = strtolower($image_new_name . '.' .$image_extension);

            try
            {
                // if image upload is not successful
                if( !$move_file )
                {
                    throw new \Exception('Failed to upload image.');
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
        // Collecting the required information
        $user = array(
            'name' => $data['username'],
            'email' => $data['email'],
            'subject' => $data['subject']
        );

        // Sending email to user
        Mail::queue( " emails.$resource ", ['data'=> $data], function ($m) use ($user)
        {
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
            // Creating instance of User class
            $user = new User();

            // Verifying the id of user
            $get_user = $user::where('id',$id)->get();
            
            $id = $get_user[0]['id'];
            $name = $get_user[0]['first_name'];

            // Generating a random string
            $key = md5($id.$name);

            $data = array('user_id'=>$id, 'token'=>$key);

            // Storing the user id and key in Activation table
            $insert_code = UserActivation::insertActivation($data);

            // Condition for checking successful db operation
            if($insert_code > 0)
            {
                return $key;    
            }

            throw new \Exception("Database Error: Failed to update Activation table");       
        }
        catch(\Exception $e)
        {
            errorReporting($e);
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
            // Instantiate the UserActivatioin Class
            $verify = UserActivation::where('token',$token)->get();
            
            // Get the id of user based on token
            $user_id = $verify[0]['user_id'];

            // Verifying the token with the requested token
            if($verify[0]['token'] == $token)
            {
                // Update the users table column activated to 1
                $user = User::find($user_id);

                // Activating the account of the user
                $user->activated = '1';
                $user->save();

                return 1;
            }
            
            throw new \Exception("Error: Invalid token has been used");
        }
        catch(\Exception $e)
        {
            // Logging error
            errorReporting($e);
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
        try
        {
            //get the information of user by user id with residence address
            if($id)
            {
                $get_user = User::where('users.id', $id)->join('addresses', 'users.id', '=', 'addresses.user_id')
                    ->join('communications','users.id', '=', 'communications.user_id')
                    ->groupBy('users.id')
                    ->select('users.id as userId', 'first_name', 'middle_name', 'last_name', 'prefix', 'gender', 'dob',
                        'marital_status', 'employer', 'employment', 'email', 'role_id', 'github_id', 'image', 'street',
                        'city', 'state', 'zip', 'mobile', 'landline', 'fax', 'communications.type')
                    ->get()
                    ->toArray(); 
            }
            else
            {   
                //get all the information of all user with residence address
                $get_user = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                    ->join('communications','users.id', '=', 'communications.user_id')
                    ->groupBy('users.id')
                    ->select('users.id as userId', 'first_name', 'middle_name', 'last_name', 'prefix', 'gender', 'dob',
                        'marital_status', 'employer', 'employment', 'email', 'role_id', 'github_id', 'image', 'street', 
                        'city', 'state', 'zip', 'mobile', 'landline', 'fax', 'communications.type')
                    ->get()
                    ->toArray(); 
            }
            
            // Where condition if request is for all user
            $condition = ([ ['addresses.type', 'office'] ]);

            // Where condition if the id is specified for the user
            if ($id)
            {
                $condition = ([ ['addresses.type', 'office'],['addresses.user_id', '=', $id] ]);
            }

            // Get the information of user related to address office
            $information_office = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                ->select( 
                    "addresses.street AS office_street",
                    "addresses.city AS office_city",
                    "addresses.state AS office_state",
                    "addresses.zip AS office_zip",
                    "addresses.mobile AS office_mobile",
                    "addresses.landline AS office_landline",
                    "addresses.fax AS office_fax"
                )->groupBy('users.id')->where($condition)
                ->get()->toArray();
                
            //array to store the all the information of user
            $information = array();

            //loop to concat the residence and office information of user
            foreach ($get_user as $key => $residence)
            {
                
                $office = $information_office[$key];
                $information[$key] = $residence + $office;
            }

            // Condition for checking if information is present or not
            if (!empty($information))
            {
                //return the complete information of user
                return $information;                
            }

            throw new \Exception("Database Error: Error occured while fetching the information");
        }
        catch (\Exception $e)
        {
            // Logging error 
            errorReporting($e);

            return 0;
        }
    }
}
