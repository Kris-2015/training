<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\Models\User;
use App\Models\RoleResourcePermission;
use App\Http\Requests;
use DB;
use Auth;

class UserController extends Controller
{
    protected $dates = ['deleted_at'];
   /**
    * Display datables front end view
    *
    * @return \Illuminate\View\View
    */
    public function getIndex()
    {

        return view('datatables.index');
    }

    /**
     * Process datatables ajax requests
     *
     * @param void
     * @return \Illuminate\Http\JsonResponse
    */
    public function anyData()
    {   

        //get user permission for datatables
        $permission = RoleResourcePermission::datatablePermission(Auth::user()->role_id,'datatables');

        //get all the records of active/deactivated user
        $users = User::withTrashed()
            ->leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
            ->where('type', 'office')
            ->select(['users.id', 'first_name', 'last_name', 'email', 'dob', 'github_id', 'users.created_at', 'users.updated_at', 'role_id', 'isActive', 'users.deleted_at', 'street', 'city', 'state']);

        //array for showing the status of users account using bootstrap button class
        $stat = [
            '0'=>'danger',
            '1'=>'primary'
        ];

        //array to show the status of users account
        $status = [
            '0'=>'Deactivate',
            '1'=>'Activate'
        ];

        return Datatables::of($users,$stat)
            ->addColumn('action', function($users) use($permission){

                //setting the variable with null values
                $edit = '';
                $delete = '';
                $result='';
                
                //checking the required permission is present in array
                if(in_array('all', $permission) || in_array('update', $permission) && in_array('delete', $permission))
                {
                    //if user has the update permission, initialise the edit variable with edit row
                    $edit = '<li><a href="register/'.$users->id.'">Edit</a></li>'; 

                    //if user has the delete permission, initialise the delete variable with delete row 
                    $delete = '<li><a href="#" class="delete" data-id="'.$users->id.'">Delete</a></li>';
                }
                else
                    if(in_array("delete", $permission))
                    {
                        $delete = '<li><a href="#" class="delete" data-id="'.$users->id.'">Delete</a></li>';
                    }
                else
                  if(in_array("update", $permission))
                    {
                        $edit = '<li><a href="register/'.$users->id.'">Edit</a></li>'; 
                    }

                if($edit != '' || $delete != '' || in_array("view", $permission))
                {

                   $result = '
                    <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action<span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a class="pro" data-id="'.$users->id.'" href="#">Profile</a></li>
                          <li><a class="git" data-github="'.$users->github_id.'" href="#">Github Profile</a></li>
                        '.$edit.'
                        '.$delete.'  
                       </ul>
                    </div>';
                }

                return $result;
            })
            ->addColumn('status', function($users) use($stat,$status){
                
                  //assuming that deleted at column is null
                  $isDeleted = 0;

                  //account deactivating button
                  $status_button = '';

                  //only admin is allowed
                  if(Auth::user()->role_id == 1)
                  {
                      //if deleted_at column is not null, then set the isDeleted to '1' to indicate 
                      //user account is not deactivated
                      if( !empty( $users->deleted_at ) )
                      {
                          $isDeleted = 1;
                      }

                      $status_button = '<button onclick="changeActivationStatus(this)" type="button" data-activate="' . $isDeleted .'" data-id="' . $users->id . '" class="btn btn-'.$stat[$isDeleted].'" btn-lg">'.$status[$isDeleted].'</button>' ;                 
                  }
                  
                  return $status_button;                
            })
            ->make(true);
    }

    /**
    * Function to get all information for user's profile
    *
    * @param: handle incoming ajax request
    * @return: json
    */
    public function postUser(Request $request)
    {

        if($request->ajax())
        {
            $user_id = $request["id"];
        
            $user_info = User::leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
                        ->leftJoin('communications','users.id', '=', 'communications.user_id')
                        ->groupBy('users.id')
                        ->select('users.id as userId', 'first_name', 'last_name', 'dob', 'gender', 'prefix',
                            'email', 'github_id', 'marital_status', 'image')
                        ->where('users.id', $user_id)
                        ->get();
                        
            return response()->json($user_info);
        }
        else
        {
            return redirect("/datatables");
        }

    }

    /**
    * Function to communicate with Github api
    *
    * @param: handle incoming ajax request
    * @return: json
    */
    public function postGit(Request $request)
    {

        $github_username = $request["gitid"];

        $username = env('GITHUB_USERNAME','kris');
        $password = env('GITHUB_PASSWORD','kris');
        $curl_url = "https://api.github.com/users/$github_username";

        $handler = curl_init();
            curl_setopt($handler, CURLOPT_URL, $curl_url);
            curl_setopt($handler, CURLOPT_USERAGENT, 'Mozilla');
            curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handler, CURLOPT_USERPWD, "$username:$password");

            //$result = curl_exec ($handler);

            curl_setopt_array($handler, array(
            CURLOPT_URL => "https://api.github.com/users/$github_username",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
         ));

        $response = curl_exec($handler);
        $err = curl_error($handler);

        curl_close($handler);

        if ($err) 
        {

          echo "cURL Error #:" . $err;
          exit;
        } 

        header('Content-Type: application/json;charset=utf-8');
        echo $response; 
        exit;
        
    }
}
