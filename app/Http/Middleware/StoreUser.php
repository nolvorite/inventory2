<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userTable       = config("laravel_user_management.users_table");
        $departmentTable = config("laravel_user_management.user_department_table");
        $tableNames      = config('permission.table_names');

        return [
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => "nullable|email|unique:$userTable,email",
            'phone_number'  => "required|unique:$userTable,mobile",
            'address' => 'nullable',
            'status' => 'nullable',
            'phone_number' => 'nullable',
            'dob' => 'nullable',

            'family_contact_number' => 'nullable',
            'employee_type' => 'nullable',
            'father_name' => 'nullable',
            'mother_name' => 'nullable',

            'shop_name' => 'nullable',
            'due_limit' => 'nullable',
            'due_limit_date' => 'nullable',
            'active_status' => 'nullable',


            'password'      => 'required|min:6',
            'roles'         => 'nullable|array',
            'roles.*'       => 'nullable|exists:'. $tableNames['roles']. ',name',
            'department_id'   => 'required'
        ];
    }
}
