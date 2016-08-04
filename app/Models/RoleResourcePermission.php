<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
            //$res='datatables';
            $permission = $rrp->select(['resources.resource_name','permissions.name'])
                            ->join('resources','role_resource_permissions.resource_id','=','resources.resource_id')
                            ->join('permissions','role_resource_permissions.permission_id','=','permissions.permission_id')
                            ->orWhere(function($query)use($id,$res)
                            {
                                $query->where('role_id',$id)
                                      ->where('resources.resource_name',$res);
                            })
                            ->get();
                    //dd($permission[0]);
            return $permission[0];
    }
}
