<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

use App\Models\RoleMenu;
class CheckRoutesRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {   
        $routes     = $this->getRequiredRoleForRoute();
        $rolesArray = explode("|", $roles);
        foreach($rolesArray as $row){
            if (in_array($row, $routes)) {
                return $next($request);
            }
        }
        return response([
            'error' => [
                'code' => 'INSUFFICIENT_ROLE',
                'description' => 'You are not authorized to access this resource.'
            ]
        ], 401); 
    }

    private function getRequiredRoleForRoute()
    {
        $user_role_menus = RoleMenu::where('role_id', Auth::user()->role_id)->pluck('menu_title')->toArray();
        return $user_role_menus;
    }

}
