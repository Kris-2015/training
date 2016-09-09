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
   * @return json / integer
   */
   public function getAuthorisationDetails(Request $request)
   {
        try
        {
            //empty array to store role, resource and permisson in an array            
            $data = [];
            $data['role'] = Role::all();   
            $data['resource'] = Resource::all();
            $data['permission'] = Permission::all();            
        
            // if there is no data, throw exception
            if ( empty($data) )
            {
                throw new \Exception('Error occured while getting AuthorisationDetails');
            }

            //returning the role, resource and permission in json
            return response()->json($data);
        }
        catch (\Exception $e)
        {
            errorReporting($e);

            return 0;
        }
   }

  /**
   * Function to get permission based on roles
   *
   * @param handle incoming request
   * @return json / integer
   */
   public function getPermission(Request $request)
   {
        try
        {
            //fetching the role and resource id from request variable
            $flag = $request->all();
            $role = $flag['role'];
            $resource = $flag['resource'];
          
            //getting the permission of resources based on role
            $resource_permission = RoleResourcePermission::where('role_id',$role)
                ->where('resource_id',$resource)->get();

            // if there is no data, throw exception
            if (empty($resource_permission))
            {
                throw new \Exception('Error occured while getting Permission of resource');
            }

            //returning the permission of resource in json 
            return response()->json($resource_permission);            
        }
        catch (\Exception $e)
        {
            errorReporting($e);

            return 0;
        }    
              
   }

   /**
    * Function to set the permission of user
    *
    * @param handle incoming request
    * @return integer
    */
   public function setPermission(Request $request)
   {
        try
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
            $status = RoleResourcePermission::addPermission($role, $resource, $permission, $action);

            if ($status == 0)
            {
                throw new \Exception('Error occured while setting permission');
            } 

            return 1;

        }
        catch (\Exception $e)
        {
            errorReporting($e);

            return 0;
        }        
   }
}
