<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;
    use SoftDeletes;
    protected $fillable = ['id', 'first_name'];

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

            $user->first_name = $data['firstname'];
            $user->middle_name = $data['middlename'];
            $user->last_name = $data['lastname'];
            $user->prefix = $data['prefix'];
            $user->gender = $data['gender'];
            $user->dob = $data['dob'];
            $user->marital_status = $data['marital_status'];
            $user->employment = $data['employment'];
            $user->employer = $data['employer'];
            $user->email = $data['email'];
            $user->github_id = $data['githubid'];
            $user->password = $password;
            $user->image = $data['uploaded_image'];
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
        	Log::error($e);
         	DB::rollBack();
            return 0;
        } 
        return 1;
   }
}
