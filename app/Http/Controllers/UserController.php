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
	/*
	 * Display datables front end view
	 *
	 * @return \Illuminate\View\View
	*/
    public function getIndex()
    {
    	return view('datatables.index');
    }

    /*
	 * Process datatables ajax requests
	 *
	 * @return \Illuminate\Http\JsonResponse
    */
    public function anyData()
    {   
        $permission = RoleResourcePermission::datatablePermission(Auth::user()->role_id,'datatables');
        $perm = $permission->name;

        $users = User::select(['id', 'first_name', 'email', 'dob', 'github_id', 'created_at', 'updated_at', 'isActive']);
        $stat = [
            '0'=>'primary',
            '1'=>'danger',
            '2'=>'warning'
        ];
        $status = [
            '0'=>'Active',
            '1'=>'Delete',
            '2'=>'Suspended'
        ];

        return Datatables::of($users,$stat)
                ->addColumn('action', function($users) use($perm){
                    $edit = '';
                    $delete = '';
                    $result='';
                if($perm == 'all' )
                {
                    $edit = '<li><a href="register/'.$users->id.'">Edit</a></li>'; 
                    $delete = '<li><a href="#" class="delete" data-id="'.$users->id.'">Delete</a></li>';
                }
                else
                    if($perm == 'delete')
                    {
                        $delete = '<li><a href="#" class="delete" data-id="'.$users->id.'">Delete</a></li>';
                    }
                else
                    if($perm == 'edit')
                    {
                        $edit = '<li><a href="register/'.$users->id.'">Edit</a></li>'; 
                    }

                if($edit != '' || $delete != '' || $perm == 'view')
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
                return '
                <button type="button" class="btn btn-'.$stat[$users->isActive].'" btn-lg">'.$status[$users->isActive].'</button>';
            })
            ->make(true);
    }

    public function postUser(Request $request)
    {
        if($request->ajax())
        {
            $user_id = $request["id"];
        
            $user_info = User::join('addresses', 'users.id', '=', 'addresses.user_id')
                        ->join('communications','users.id', '=', 'communications.user_id')
                        ->groupBy('users.id')
                        ->where('users.id', $user_id)
                        ->get();
            
            return json_encode($user_info);
        }
        else
        {
            return redirect("/datatables");
        }
    }

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

            $result = curl_exec ($handler);

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

        if ($err) {
          echo "cURL Error #:" . $err;
          exit;
        } 
        header('Content-Type: application/json;charset=utf-8');
        echo $response; 
        exit;
    }
}
