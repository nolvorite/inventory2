<?php

namespace App\Entities;
use Mekaeil\LaravelUserManagement\Entities\User as UserManagement;

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



    ////// !!! IMPORTANT !!!
    ////// WE ENCRYPT PASSWORD IN MODEL YOU CAN OVERWRITE IT AND REMOVE IT
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }    

}