<?php

namespace App\Entities;
use Illuminate\Support\Facades\DB;
use Mekaeil\LaravelUserManagement\Entities\User as UserManagement;
use Laravel\Passport\HasApiTokens;

class User extends UserManagement
{


    protected $fillable = [
        'name', 'email', 'password', 'email_verified', 'mobile_verified',

        'first_name', 'last_name', 'status',

        'address', 'phone_number', 'dob', 'family_contact_number',

        'employee_type', 'father_name', 'mother_name',

        'shop_name', 'due_limit', 'due_limit_date', 'active_status',

        'reference_name', 'note', 'nid'
    ];

    public static function withDept(){
        return (new static)->select(DB::Raw('*,users.id AS user_id'))->join('user_departments_users','user_departments_users.user_id','=','users.id')->where('department_id',env('MANAGER_DEPARTMENT_ID'))->orderByDesc('created_at')->get();
    }

    public static function withCustomers(){
        return (new static)->join('user_departments_users','user_departments_users.user_id','=','users.id')->where('department_id',env('CUSTOMER_DEPARTMENT_ID'))->orderByDesc('created_at')->get();
    }
        



    ////// !!! IMPORTANT !!!
    ////// WE ENCRYPT PASSWORD IN MODEL YOU CAN OVERWRITE IT AND REMOVE IT
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }    

}