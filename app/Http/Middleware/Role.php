<?php

namespace App\Http\Middleware;
use \Illuminate\Support\Facades\Auth;
use \App\UserDepartmentsUser;
use Closure;
use \Illuminate\Http\Request;
use \App\User;

class Role
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle(Request $request, Closure $next, $role)
    {

        $userId = Auth::id();

        $hasAccess = false;

        $currentRole = UserDepartmentsUser::where(['user_id' => $userId])->first();

        switch($role){
            case "employee":
                $list = UserDepartmentsUser::where(['user_id' => $userId, 'department_id' => env('MANAGER_DEPARTMENT_ID')])->get();
                $hasAccess = count($list) > 0;
            break;
            case "customer":
                $list = UserDepartmentsUser::where(['user_id' => $userId, 'department_id' => env('CUSTOMER_DEPARTMENT_ID')])->get();
                $hasAccess = count($list) > 0;
            break;
        }

        if($currentRole !== null && $currentRole->department_id.'' === env('ADMIN_DEPARTMENT_ID').''){
            $hasAccess = true;
        }

        if(count(User::all()) === 1 || Auth::id().'' === '1'){
            $hasAccess = true; //first user
        }

        if($request->wantsJson()){
            $hasAccess = true;
        }

        if(!$hasAccess){
            return redirect()->route('no_access');
        }

        $request->role_data = $currentRole;

        return $next($request);
    }
}
