<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class RoleResourcePermission extends Model
{

    /**
	 * Function to get permission of edit and delete
     *
     * @param role id and resource
     * @return array
    */
    public static function datatablePermission($id,$res)
    {
    	$rrp = new RoleResourcePermission();
        
        $permission = $rrp->select(['resources.resource_name','permissions.name'])
                        ->join('resources','role_resource_permissions.resource_id','=','resources.resource_id')
                        ->join('permissions','role_resource_permissions.permission_id','=','permissions.permission_id')
                        ->orWhere(function($query)use($id,$res)
                        {
                            $query->where('role_id',$id)
                                  ->where('resources.resource_name',$res);
                        })
                        ->get();
                    
            return $permission[0];
    }

    /**
     * Check permission of the user about the accessibility of resource
     *
     * @param reosurce, user_id
     *
     * @return boolean
    */
    public static function checkPermission($resource,$action)
    {
        $rrp = new RoleResourcePermission();

        $roleId = Auth::user()->role_id;
        $resourceId = Resource::where('resource_name',$resource)->first()->resource_id;
        $permissionId = Permission::where('name',$action)->first()->permission_id;

        $adminPermission = Permission::where('name', 'all')->first()->permission_id;

        $userAccess = $rrp->where('role_id', $roleId)
            ->where('resource_id',$resourceId)
            ->where('permission_id', $permissionId)
            ->first();
        $adminAccess = $rrp->where('role_id', $roleId)
            ->where('resource_id',$resourceId)->where('permission_id', $adminPermission)
            ->first();

        if($adminAccess != null || $userAccess !=null)
        {
            return 1;
        }
        return 0;
    }

    public static function addPermission($role, $resource, $permission,$action)
    {
        $rrp_obj = new RoleResourcePermission();
        if($action == 'add')
        {
            //checking whether the requested permission for the role and resource exists or not
            $check_request = $rrp_obj->where('role_id', $role)
                ->where('resource_id', $resource)
                ->where('permission_id', $permission)
                ->first();
                
            if($check_request == NULL)
            {
               
                $rrp_obj ->role_id = $role;
                $rrp_obj ->resource_id = $resource;
                $rrp_obj ->permission_id = $permission;
                $added_permission = $rrp_obj ->save();

                return 1;
            }

        }
        else if($action == 'delete')
        {
            $delete_permission = $rrp_obj->where('role_id', $role)
                ->where('resource_id', $resource)
                ->where('permission_id', $permission)
                ->delete();
            
        }
    }
    
}
