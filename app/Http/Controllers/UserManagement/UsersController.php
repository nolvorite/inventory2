<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mekaeil\LaravelUserManagement\Repository\Contracts\PermissionRepositoryInterface;
use Mekaeil\LaravelUserManagement\Repository\Contracts\RoleRepositoryInterface;
use Mekaeil\LaravelUserManagement\Repository\Contracts\UserRepositoryInterface;
use Mekaeil\LaravelUserManagement\Repository\Eloquents\DepartmentRepository;
use App\Http\Middleware\StoreUser;
use App\Http\Middleware\UpdateUser;
use App\Entities\User;

class UsersController extends Controller
{
    protected $userRepository;
    protected $permissionRepository;
    protected $roleRepository;
    protected $departmentRepository;

    public function __construct(
        UserRepositoryInterface $user,
        PermissionRepositoryInterface $permission,
        RoleRepositoryInterface $role,
        DepartmentRepository $department)
    {
        $this->permissionRepository = $permission;
        $this->roleRepository       = $role;
        $this->userRepository       = $user;
        $this->departmentRepository = $department;
    }

    public function index()
    {
        // $users          = $this->userRepository->all();
        $users          = $this->userRepository->allWithTrashed();

        return view('user-management.user.index', compact('users'));
    }

    public function index_e()
    {
        // $users          = $this->userRepository->all();
        $users = User::join('user_departments_users','user_departments_users.user_id','=','users.id')->where('department_id',env('MANAGER_DEPARTMENT_ID'))->orderByDesc('created_at')->get();

        if(request()->get('filter') !== null){
            $filter = request()->get('filter');
            switch($filter){
                case "BP":
                case "DSR":
                    $users = User::join('user_departments_users','user_departments_users.user_id','=','users.id')
                    ->where([
                        'department_id' => env('MANAGER_DEPARTMENT_ID'),
                        'employee_type' => $filter
                    ])->orderByDesc('created_at')->get();
                break;
                default:
                    return redirect()
                    ->route('products.index');
                break;
            }
        }

        $isCustom = 'employees';

        return view('user-management.user.index', compact('users', 'isCustom'));
    }

     public function index_c()
    {
        // $users          = $this->userRepository->all();


        $criteria = ['department_id' => env('CUSTOMER_DEPARTMENT_ID')];

        if(request()->wantsJson()){

            $criteria['active_status'] = 'active';

        }


        $users = User::join('user_departments_users','user_departments_users.user_id','=','users.id')->where($criteria)->orderByDesc('created_at')->get();

        $isCustom = 'customers';

        if(request()->wantsJson()){

            return response()->json(compact('users'));

        }

        return view('user-management.user.index', compact('users', 'isCustom'));
    }

    public function create()
    {
        $roles       = $this->roleRepository->all();
        $departments = $this->departmentRepository->all();

        return view('user-management.user.create', compact('roles', 'departments'));
    }

    public function edit($ID)
    {
        if($user = $this->userRepository->find($ID))
        {
            $roles              = $this->roleRepository->all();
            $departments        = $this->departmentRepository->all();
            $userHasRoles       = $user->roles ? array_column(json_decode($user->roles, true), 'id') : [];
            $userHasDepartments = $user->departments ? array_column(json_decode($user->departments, true), 'id') : [];
    
            return view('user-management.user.edit', compact('roles', 'departments', 'user', 'userHasRoles', 'userHasDepartments'));    
        }

        return redirect()->back()->with('message',[
            'type'  => 'danger',
            'text'  => 'This user does not exist!',
        ]);

    }

    public function store(StoreUser $request)
    {

        $data = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'name'          => $request->first_name . " " . $request->last_name,
            'email'         => $request->email,
            'mobile'        => $request->phone_number,
            'address'       => $request->address,
            'phone_number'  => $request->phone_number,
            'status'        => 'accepted' ,

            'dob'      => $request->dob."",
            'family_contact_number'      => $request->family_contact_number."",

            'employee_type'      => $request->employee_type."",
            'father_name'      => $request->father_name."",
            'mother_name'      => $request->mother_name."",

            'shop_name'      => $request->shop_name."",
            'due_limit'      => $request->due_limit."",
            'due_limit_date'      => $request->due_limit_date."",
            'active_status'      => 'active',

            'note'      => $request->note."",
            'nid'      => $request->nid."",
            'reference_name'      => $request->reference_name.""

        ];

        if($request->password !== null){
            $data['password'] = $request->password;
        }



        $user = $this->userRepository->store($data);
    
        $roles       = $request->roles       ?? [];
        $departments = $request->departments ?? [];
        
        $this->roleRepository->setRoleToMember($user, $roles);
        $this->departmentRepository->attachDepartment($user, $departments);



        $route = $departments[0].'' === env('MANAGER_DEPARTMENT_ID').'' ? 'index_e' : 'index_c';

        return redirect()->route('admin.user_management.user.'.$route)->with('message',[
            'type'   => 'success',
            'text'   => 'َUser created successfully!' 
        ]);
    }

    public function show($id){

        $userData = User::findOrFail($id)->first();

        unset(
            $userData->first_name,
            $userData->last_name,
            $userData->password,
            $userData->updated_at,
            $userData->deleted_at,
            $userData->shop_name,
            $userData->due_limit,
            $userData->due_limit_date
        );

        return response()->json($userData);
    }

    public function update(int $ID, UpdateUser $request)
    {

        if($user = $this->userRepository->find($ID))
        {
            $user = $this->userRepository->update($ID, [
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'name'          => $request->first_name . " " . $request->last_name,
                'email'         => $request->email,
                'mobile'        => $request->phone_number,
                'address'        => $request->address,
                'phone_number'  => $request->phone_number,
                'status'        => 'accepted',
                'password'      => $request->password,

                'dob'      => $request->dob."",
                'family_contact_number'      => $request->family_contact_number."",

                'employee_type'      => $request->employee_type."",
                'father_name'      => $request->father_name."",
                'mother_name'      => $request->mother_name."",

                'shop_name'      => $request->shop_name."",
                'due_limit'      => $request->due_limit."",
                'due_limit_date'      => $request->due_limit_date."",
                'active_status'      => $request->active_status."",

                'note'      => $request->note."",
                'nid'      => $request->nid."",
                'reference_name'      => $request->reference_name.""

            ]);

        
            $roles       = $request->roles       ?? [];

            $departments = $request->departments ?? [];
            if(count($departments) == 1 && $departments[0] == null)
            {
                $departments = []; 
            }
            //// IF WE WANT TO CHANGE PASSWORD
            ////////////////////////////////////////////////////////////
            if($request->password)
            {
                $this->userRepository->update($ID, [
                    'password'       => bcrypt($request->password)
                ]);
            }
            ////////////////////////////////////////////////////////////

            // $this->roleRepository->syncRoleToUser($user, $roles);
            // $this->departmentRepository->syncDepartments($user, $departments);
       
            return redirect()->route('admin.user_management.user.index_c')->with('message',[
                'type'   => 'success',
                'text'   => 'َUser updated successfully!' 
            ]);
        }

        return redirect()->back()->with('message',[
            'type'  => 'danger',
            'text'  => 'This user does not exist!',
        ]);
        
    }

    public function delete($ID)
    {
        if($user = $this->userRepository->find($ID))
        {
            //// soft delete
            $this->userRepository->update($ID, [
                'status'    => 'deleted'
            ]);
            $user->delete();

            return redirect()->route('admin.user_management.user.index')->with('message',[
                'type'   => 'warning',
                'text'   => 'User Deleted successfully!' 
            ]);
        }

        return redirect()->back()->with('message',[
            'type'  => 'danger',
            'text'  => 'This user does not exist!',
        ]);
    }

    public function restoreBackUser(int $ID)
    {
        
        if($this->userRepository->restoreUser($ID))
        {
            $user = $this->userRepository->update($ID, [
                'status'    => 'accepted',
            ]);

            return redirect()->route('admin.user_management.user.index')->with('message',[
                'type'   => 'success',
                'text'   => 'User restored successfully!' 
            ]);
        }

        return redirect()->back()->with('message',[
            'type'  => 'danger',
            'text'  => 'This user does not exist!',
        ]);
    }
}
