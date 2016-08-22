<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests;
use Auth;

class ApiController extends Controller
{

    /**
     * Function to return data of all user
     *
     * @param Request, action( user_id / {add, update, delete} )
     * @return array
    */
    public function postUsers(Request $request, $action = '')
    {
        //checking for authenticate user
        if ( ! Auth::once(['email' => $request->email, 'password' => $request->password, 'activated'=>'1']))
        {
            return response()->json(array('status' => false , 'message' => 'Parameters Missing'), 403);
            exit;
        }

        switch($action)
        {
            case 'add':
                    $data =  $this->postAddUser($request);
                break;

            case 'update':
                    $data =  $this->postUpdateUser($request);
                break;

            case 'delete':
                    $data =  $this->postDeleteUser($request);
                break;

            default:
                    $data = $this->user($request, $action);
                break;
        }

        return response()->json($data); 
        exit;

        
    }

    public function user($request, $id)
    {
        //dd($request->all());
        //limiting the number of records
        $limit  = isset($request->limit) ? $request->limit : 5;
        $mobile = isset($request->mob)? $request->mob : '';
        $name   = isset($request->name)? $request->name : '';

        if ( ! Auth::once(['email' => $request->email, 'password' => $request->password, 'activated'=>'1']))
        {
            return response()->json(array('status' => false , 'message' => 'Parameters Missing'), 403);
        }
        
        if ($id == 0)
        {
            if (isset($limit) && is_numeric($limit))
            {
                
                $users = User::with('Address')
                    ->where('first_name', 'like', '%'.$name.'%')
                    ->paginate($limit);    
            }
            else
            {
                
                $users = User::with('Address')
                    ->where('first_name', 'like', '%'.$name.'%')
                    ->paginate($limit);
            }
            
        }
        else
        {
            $users = User::with('Address')
                ->find($id);  
        }
        
        return isset($users)? $users : array('status' => '404', 'message' => 'Not Found');
    }

    /**
     * Function to create user
     *
     * @param request
     * @return array
    */
    public function postAddUser(Request $request)
    {
        //authenticating the user
        if ( ! Auth::once(['email' => $request->email, 'password' => $request->password, 'activated'=>'1']))
        {
            return response()->json(array('status' => false , 'message' => 'Parameters Missing'), 403);
        }
        
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
    public function postUpdateUser(Request $request)
    {
        //authenticating the user
        if ( ! Auth::once(['email' => $request->email, 'password' => $request->password, 'activated'=>'1']))
        {
            return response()->json(array('status' => false , 'message' => 'Parameters Missing'), 403);
        }

        $name = $request->name;
        $update_name = $request->update_name;

        $update_user = User::withTrashed()
            ->where('first_name', $name)
            ->update(['first_name' => $name]);
        
        if($update_user > 0)
        {
            $code = '114';
            $info = 'Update user successfully';
        }    
        else
        {
            $code = '114';
            $info = 'Update user successfully';
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
    public function postDeleteUser($request)
    {
        //dd($request->all());
        $id = $request->id;
        $message = 'Wrong Id!';
        $code = 456;

        $find_id = User::withTrashed()
            ->where('id', $id)
            ->get();
        
            if  (!$find_id->isEmpty()) {
        if($find_id[0]['deleted_at'] != null)
        {
            $code = '110';
            $message = 'memeber already deleted';
        }
        else
        {
            $code = '105';
            $message = 'failed to delete....try again later';
            $delete = User::find($find_id[0]['id'])
                ->delete();

            if($delete > 0)
            {
                $code = '104';
                $message = 'deleted successfully';
            }
        }}

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