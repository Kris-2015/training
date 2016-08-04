<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class RoleResourcePermission extends Model
{
    /**
	* table is assosciated with models
	*
	* @var String
	*/
    //$protected $table = 'role_resource_permission';

    /**
	 * Function to get all permission
    */
    public static function getPermission($id,$res)
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

        $userAccess = RoleResourcePermission::where('role_id', $roleId)
            ->where('resource_id',$resourceId)
            ->where('permission_id', $permissionId)
            ->first();
        $adminAccess = RoleResourcePermission::where('role_id', $roleId)
            ->where('resource_id',$resourceId)->where('permission_id', $adminPermission)
            ->first();

        if($adminAccess != null || $userAccess !=null)
        {
            return 1;
        }
        return 0;
    }

    public static function AddPermission($role, $resource, $permission,$action)
    {

    }
    
}
