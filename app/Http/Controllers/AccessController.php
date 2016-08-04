<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Resource;
use App\Models\Permissions;
use App\Models\RoleResourcePermission;
use Auth;
use DB;

class AccessController extends Controller
{
   /*
	 * Display admin panel front end view
	 *
	 * @return \Illuminate\View\View
	*/
   public function showPanel()
   {
   		return view('panel');
   }

   /*
	 * Process datatables ajax requests
	 *
	 * @return \Illuminate\Http\JsonResponse
    */
   public function getrrp(Request $request)
   {
   	 $flag = $request->all()['start']; 
   	 if($flag == 1)
   	 {
   	 	$data = [];
   	 	$data['role'] = DB::table('roles')->get();   
   	 	$data['resource'] = DB::table('resources')->get();
   	 	$data['permission'] = DB::table('permissions')->get();

        echo json_encode($data);
   	 }
   }

   public function getPerm(Request $request)
   {
        //DB::enableQueryLog();

   	    $req = $request->all();
        $flag2 = $req['start'];
        $role = $req['role'];
        $resource = $req['resource'];

         if($flag2 == 2)
         {
            $getrrp = new RoleResourcePermission();
            $data = array();
            $resource_permission = DB::table('role_resource_permissions')
                        ->where('role_id',$role)
                        ->where('resource_id',$resource)->get();

            echo json_encode($resource_permission);      
        }
   }

   public function setPermission(Request $request)
   {
        $get = $request->all();
        $flag3 = $get['start'];
        $role = $get['role'];
        $resource = $get['resource'];
        $permission = $get['permission'];
        
        dd($get);
   }
}
