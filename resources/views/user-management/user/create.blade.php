@extends('layouts.app', ['page' => 'Create New User ', 'pageSlug' => 'users', 'section' => 'inventory'])

<?php
    $registrationType = substr(Request::url(), strrpos(Request::url(), '/') + 1);
    $employeeTypeValue = old('employee_type');

    $errorMessage = '';


    if($errors->all() !== null){
        foreach($errors->all() as $error){
            $errorMessage .= $error . "<br>";
        }
    }

?>

@section('content')

<form class="forms-sample" method="POST" action="{{ route('admin.user_management.user.store') }}">
    {!! csrf_field() !!}

    @if(count($errors) > 0)

    <div class="alert alert-warning">
        {{ $errorMessage }}
    </div>

    @endif

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" id="first_name" placeholder="First Name like: Mekaeil">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" id="last_name" placeholder="Last Name like: Andisheh">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            
                            @switch($registrationType)

                            @case('employee')
                            <select multiple class="form-control d-none" name="departments[]" id="guard_name">

                                @forelse ($departments as $item)
                                    <option value="{{ $item->id }}"{{ env('MANAGER_DEPARTMENT_ID')."" === $item->id."" ? ' selected' : '' }}>{{ $item->title }}</option>
                                @empty
                                    
                                @endforelse
                            </select>
                            @break

                            @case('customer')
                            <select multiple class="form-control d-none" name="departments[]" id="guard_name">
         
                                @forelse ($departments as $item)
                                    <option value="{{ $item->id }}"{{ env('CUSTOMER_DEPARTMENT_ID')."" === $item->id."" ? ' selected' : '' }}>{{ $item->title }}</option>
                                @empty
                                    
                                @endforelse
                            </select>
                            @break

                            @default
                            <label for="guard_name">Departments</label>
                            <select multiple class="form-control" name="departments[]" id="guard_name">
     
                                @forelse ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @empty
                                    
                                @endforelse
                            </select>
                            @break

                            @endswitch
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" placeholder="example@mekaeil.me">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Mobile</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="form-control" id="phone_number" placeholder="Mobile number like: 091xxxxxxxx">
                        </div>
                    </div><!--
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Account Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="pending">pending</option>
                                <option value="accepted">accepted</option>
                                <option value="blocked">blocked</option>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">NID</label>
                            <input type="text" name="nid" value="{{ old('nid') }}" class="form-control" id="nid" placeholder="Your NID here...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control" id="address" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob">Date Of Birth</label>
                            <input type="text" name="dob" value="{{ old('dob') }}" class="form-control dated" id="dob" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile">Emergency Contact #</label>
                            <input type="text" name="family_contact_number" value="{{ old('family_contact_number') }}" class="form-control" id="dob" placeholder="">
                        </div>
                    </div>
               
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
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
                            <input type="text" name="father_name"  value="{{ old('father_name') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Mother's Name</label>
                            <input type="text" name="mother_name" value="{{ old('mother_name') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Reference Name</label>
                            <input type="text" name="reference_name" value="{{ old('reference_name') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Employee Notes</label>
                            <textarea class="form-control" value="{{ old('note') }}"></textarea>
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
                            <input type="text" name="shop_name" value="{{ old('shop_name') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="due_limit" autocomplete="off" >Due Limit</label>
                            <input type="text" name="due_limit" value="{{ old('due_limit') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="due_limit">Due Limit Days</label>
                            <input type="text" autocomplete="off" name="due_limit_date" value="{{ old('due_limit_date') }}" class="form-control">
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