<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Communication;
use App\Http\Requests;
use Auth;

class ApiController extends Controller
{

    public function postIndex(Request $request)
    {
        return response()->json(array('status' => false , 'message' => 'Incorrect URL'), 404);
    }

    /**
     * Function to return data of all user
     *
     * @param Request, 
     * @param action( user_id / {add, update, delete} )
     * @return array
    */
    public function postUsers(Request $request, $action = '')
    {
        //checking for authenticate user
        if ( ! Auth::once(['email' => $request->email, 'password' => $request->password, 'activated'=>'1']))
        {
            return response()->json(array('status' => false , 'message' => 'Parameters Missing'), 403);   
        }

        $isAllowed  = array(
            'add',
            'update',
            'delete'
            );

        if(!in_array($action, $isAllowed) && !empty($action))
        {
            return response()->json(array('status' => false , 'message' => 'Incorrect URL'), 404);
        }

        switch($action)
        {
            case 'add':
                    $data =  $this->postAddUser($request);
                break;

            case 'update':
                    $data =  $this->postUpdate($request);
                break;

            case 'delete':
                    $data =  $this->postDeleteUser($request);
                break;

            default:
                    $data = $this->User($request, $action);
                break;
        }

        return response()->json($data); 
            
    }

    private function User($request, $id)
    {
        //limiting the number of records
        $limit  = isset($request->limit) ? $request->limit : 5;

        //array for search parameter
        $filter = array(
            'name'   => 'first_name',
            'mobile' => 'mobile',
            'state'  => 'state' 
        );

        if ($id == 0 && is_numeric($limit) )
        {
            //checking user on the basic of required and available search parameter
            $users = User::leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
            ->where(function($query) use ($request, $filter)
            {
                foreach ( $filter as $column => $key )
                {
                    $value = array_get($request, $key);

                    if ( ! is_null($value)) $query->where($column, 'like', '%'.$value.'%');
                }
            })
            ->paginate($limit);
        }
        else
        {
            $users = User::with('Address')
                ->find($id);  
        }

        return (isset($users) && ! $users->isEmpty()) ? $users : array('status' => '404', 'message' => 'Not Found');
    }

    /**
     * Function to create user
     *
     * @param request
     * @return array
    */
    private function postAddUser(Request $request)
    {        
        //storing the data from request parameter
        $first_name = $request->firstname;
        $middle_name = $request->middlename;
        $last_name = $request->lastname;
        $prefix = $request->prefix;
        $gender = $request->gender;
        $dob = $request->dob;
        $marital_status = $request->marital_status;
        $employment = $request->employment;
        $employer = $request->employer;
        $email = $request->email_id;
        $password = 'mindfire';
        $homecity = $request->homecity;
        $homestate = $request->homestate;

        //collecting data in an array
        $data = array(
            'firstname' => $first_name,
            'middlename' => $middle_name,
            'lastname' => $last_name,
            'prefix' => $prefix,
            'gender' => $gender,
            'dob' => $dob,
            'marital_status' => $marital_status,
            'employment' => $employment,
            'employer' => $employer,
            'email' => $email,
            'password' => $password,
            'homecity' => $homecity,
            'homestate' => $homestate
        );
        
        //performing inserting operation
        $insert = User::insertUser($data);
        
        //checking if the insertion is successful or not
        if($insert > 0)
        {
            $code = '102';
            $status = 'Insert successfully';
        }
        else
        {
            $code = '101';
            $status = 'Failed to add user....try again later';
        }
        
        //returning the message with code
        $res = ['code' => $code, 'message' => $status];

        return $res;
    }

    /**
     * Function to update the user detail
     *
     * @param request
     * @return json message
    */
    private function postUpdate(Request $request)
    {
        $id = $request->id;

        //update user by id
        $update_name = $request->update_name;

        $find_user = User::withTrashed()
            ->find($id)->get();

        if($find_user->isEmpty())
        {
            $code = '114';
            $info = 'User does not exist.';    
        }
        else
        {
            $code = '114';
            $info = 'Failed to update....try again later.';

            $update_user = User::withTrashed()
            ->where('id', $id)
            ->update(['first_name' => $update_name]);
        
            if($update_user > 0)
            {
                $code = '114';
                $info = 'Update user successfully';
            }
        }
              
        //returning the message with code
        $res = ['code' => $code, 'message' => $info];

        return $res;
    }

    /**
     * Function to delete the user
     *
     * @param request
     * @return json message
    */
    private function postDeleteUser($request)
    {
        $id = $request->id;

        $message = 'Wrong Id!';
        $code = 456;

        $find_id = User::withTrashed()
            ->where('id', $id)
            ->get();
        
        if  (!$find_id->isEmpty())
        {
            if($find_id[0]['deleted_at'] != null)
            {
                $code = '110';
                $message = 'memeber already deleted';
            }
            else
            {
                $code = '105';
                $message = 'failed to delete....try again later';

                $delete_communication = Communication::where('user_id', $find_id[0]['id'])
                    ->forceDelete();

                $delete_address = Address::where('user_id', $find_id[0]['id'])
                    ->forceDelete();

                $delete_user = User::find($find_id[0]['id'])
                    ->forceDelete();
                   
                if($delete_user > 0)
                {
                    $code = '104';
                    $message = 'deleted successfully';
                }
            }
        }

        //retunning the message with code
        $res = ['code' => $code, 'message' => $message];
        
        return $res;
    }

    /**
     * Function to check the user-agent and browser
     *
     * @param void
     * @return string
     */
    public function blockBrowser()
    {
        //get user agent
        $u_agent = $_SERVER['HTTP_USER_AGENT'];

        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            //browser name
            $bname = 'Mozilla Firefox'; 
            //user agent browser
            $ub = "Firefox"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
           $bname = 'Google Chrome'; 
           $ub = "Chrome"; 
        }
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        } 

        return $ub;
    }
}