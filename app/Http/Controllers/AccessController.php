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
   * Function to get role, resource and permission
   *
   * @param handle request
   * @return \Illuminate\Http\JsonResponse
    */
   public function getrrp(Request $request)
   {
     //flag variable for getting role resource and permission
     $start = $request->all()['start']; 
     if($start == 1)
     {
      $data = [];
      $data['role'] = DB::table('roles')->get();   
      $data['resource'] = DB::table('resources')->get();
      $data['permission'] = DB::table('permissions')->get();

        echo json_encode($data);
     }
   }

   /*
   * Function to get permission based on roles
   *
   * @param handle request
   * @return \Illuminate\Http\JsonResponse
    */
   public function getPermission(Request $request)
   {
    
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
        $temp = $get['start'];
        $role = $get['role'];
        $resource = $get['resource'];
        $permission = $get['permission'];
        $action = $get['action'];
        
        if($temp == 3)
        {
            $setrrp = RoleResourcePermission::addPermission($role, $resource, $permission, $action); 
        }
   }
}