<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleResourcePermission;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        
        $resource = explode('/',$request->getPathInfo())[1];
        $action = 'view';
        $role_id = Auth::user()->id;
        //dd($resource);
        //if user try to access list
         if($resource == 'list')
        {
            $action = 'view';
        }


        if($resource == 'delete')//if user to tries to delete
        {   
            if(Auth::user()->id == $request->id)
            {
                $resource = 'datatables';
                $action = 'delete';    
            }
            else
            {
                return redirect('dashboard')->with('access','Unauthorized Access');
            }
        }

        if($resource == 'edit')//if user tries to edit info
        {
            if(Auth::user()->id == $request->id)
            {
                $action = 'update';
            }
            else
            {
               return redirect('dashboard')->with('access','Unauthorized Access'); 
            }
        }

        if($resource == 'do-update')
        {
            if(Auth::user()->id == $request->id)
            {
               $action = 'update';
            }
            else
            {
               return redirect('dashboard')->with('access','Unauthorized Access'); 
            }
        }

        //checking authorization of user
        if(!RoleResourcePermission::checkPermission($resource, $action))
        {
            return redirect('login')->with('warning','Unauthorized Access');
        } 

        //Process further if there is no error
        return $next($request);
    }
}
