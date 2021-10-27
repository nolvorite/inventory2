<?php

    $userDepartmentId = $user->getRelations()['departments'][0]->id."";

    switch($userDepartmentId){
        case "".env('MANAGER_DEPARTMENT_ID'):
            $registrationType = "employee";
        break;
        case "".env('CUSTOMER_DEPARTMENT_ID'):
            $registrationType = "customer";
        break;
        default:
            $registrationType = "";
        break; 
    }
    
    $employeeTypeValue = old('employee_type', $user->employee_type);

?>

@extends('layouts.app', ['page' => 'Editing Account: '.$user->email, 'pageSlug' => 'users', 'section' => 'inventory'])



@section('content')

<form class="forms-sample" method="POST" action="{{ route('admin.user_management.user.update', $user->id) }}">
    {!! csrf_field() !!}

    @method('put')

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control" id="first_name" placeholder="First Name like: Mekaeil">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control" id="last_name" placeholder="Last Name like: Andisheh">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ old('email',$user->email) }}" class="form-control" id="email" placeholder="example@mekaeil.me">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Mobile</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number',$user->phone_number) }}" class="form-control" id="phone_number" placeholder="Mobile number like: 091xxxxxxxx">
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Account Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="pending"{{ $user->status === 'pending' ? ' selected' : '' }}>pending</option>
                                <option value="accepted"{{ $user->status === 'accepted' ? ' selected' : '' }}>accepted</option>
                                <option value="blocked"{{ $user->status === 'blocked' ? ' selected' : '' }}>blocked</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">NID</label>
                            <input type="text" name="nid" value="{{ old('nid', $user->nid) }}" class="form-control" id="nid" placeholder="Your NID here...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" value="{{ old('address',$user->address) }}" class="form-control" id="address" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob">Date Of Birth</label>
                            <input type="text" name="dob" value="{{ old('dob',$user->dob) }}" class="form-control dated" id="dob" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile">Emergency Contact #</label>
                            <input type="text" name="family_contact_number" value="{{ old('family_contact_number',$user->family_contact_number) }}" class="form-control" id="dob" placeholder="">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee_type">Active Status</label>
                            <select name="active_status" class="form-control">
                                <option value="active"{{ $user->active_status === 'active' ? ' selected' : '' }}>active</option>
                                <option value="inactive"{{ $user->active_status === 'inactive' ? ' selected' : '' }}>inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Set New Password</label>
                            <input type="text" name="password" value="{{ old('password') }}" class="form-control" id="password" placeholder="Min character is 6">
                        </div>
                    </div>
                </div>

               
            </div>
        </div>
    </div>

    @switch($registrationType)
    
    @case('employee')

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee_type">Employee Type</label>
                            <select name="employee_type" class="form-control">
                                <option value="BP"{{ $employeeTypeValue === 'BP' ? ' selected' : '' }}>BP</option>
                                <option value="DSR"{{ $employeeTypeValue === 'DSR' ? ' selected' : '' }}>DSR</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Father's Name</label>
                            <input type="text" name="father_name"  value="{{ old('father_name', $user->father_name) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Mother's Name</label>
                            <input type="text" name="mother_name" value="{{ old('mother_name', $user->mother_name) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Reference Name</label>
                            <input type="text" name="reference_name" value="{{ old('reference_name', $user->reference_name) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Employee Notes</label>
                            <textarea class="form-control" name="note">{{ old('note', $user->note) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @break

    @case('customer')

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="shop_name">Shop Name</label>
                            <input type="text" name="shop_name" value="{{ old('shop_name', $user->shop_name) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="due_limit">Due Limit</label>
                            <input type="text" name="due_limit" value="{{ old('due_limit', $user->due_limit) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="due_limit">Due Limit Days</label>
                            <input type="text" name="due_limit_date" value="{{ old('due_limit_date', $user->due_limit_date) }}" class="form-control">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @break

    @default

    @break

    @endswitch

    <div class="col-12 grid-margin stretch-card">
        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
        <a href="{{ route('admin.user_management.user.index') }}" class="btn btn-light">Cancel</a>
    </div>
</form>

@endsection
@push('js')
<script type="text/javascript">
    $(".dated").datetimepicker({timepicker:false, format:'Y/m/d'});
</script>
@endpush