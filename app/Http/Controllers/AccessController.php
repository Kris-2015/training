<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Resource;
use App\Models\Permission;
use App\Models\RoleResourcePermission;
use Auth;
use DB;

/**
 * Manage the role, resource and permission
 * @access public
 * @package App\Http\Controllers
 * @subpackage void
 * @category void
 * @author mfsi-krishnadev
 * @link void
 */

class AccessController extends Controller
{
  /**
   * Display admin panel front end view
   *
   * @param void
   * @return \Illuminate\View\View
  */
   public function showPanel()
   {
        return view('panel');
   }

  /**
   * Function to get role, resource and permission
   *
   * @param handle incoming request
   * @return json
   */
   public function getrrp(Request $request)
   {

        //empty array to store role, resource and permisson in an array            
        $data = [];
        $data['role'] = Role::all();   
        $data['resource'] = Resource::all();
        $data['permission'] = Permission::all();

        //returning the role, resource and permission in json
        return response()->json($data);
   }

  /**
   * Function to get permission based on roles
   *
   * @param handle incoming request
   * @return json
   */
   public function getPermission(Request $request)
   {
        //fetching the role and resource id from request variable
        $flag = $request->all();
        $role = $flag['role'];
        $resource = $flag['resource'];
      
        //getting the permission of resources based on role
        $resource_permission = RoleResourcePermission::where('role_id',$role)
                    ->where('resource_id',$resource)->get();

        //returning the permission of resource in json 
        return response()->json($resource_permission);    
              
   }

   /**
    * Function to set the permission of user
    *
    * @param handle incoming request
    * @return void
    */
   public function setPermission(Request $request)
   {
        //fetching the role id, resource id and permission id from request variable
        $get = $request->all();
        $role = $get['role'];
        $resource = $get['resource'];
        $permission = $get['permission'];

        // action variable determines the permission of resources and role of user
        // example: add and delete
        $action = $get['action'];
        
        //setting the permision of resource based on role  
        RoleResourcePermission::addPermission($role, $resource, $permission, $action); 
   }
}