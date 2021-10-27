<?php

    $collection = 'Users';

    if(isset($isCustom)){
        switch($isCustom){
            case "employees":
                $collection = "Employees";
            break;
            case "customers":
                $collection = "Customers";
            break;
        }
    }

    $pageName = 'List Of '.$collection;

?>

@extends('layouts.app', ['page' => $pageName, 'pageSlug' => 'users', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">{{ $pageName }} 

                                @if(isset($isCustom) && $isCustom === 'employees')

                                <a href='{{ route('admin.user_management.user.index_e') }}?filter=BP' class='btn btn-sm btn-dark'>BP</a>
                                <a href='{{ route('admin.user_management.user.index_e') }}?filter=DSR' class='btn btn-sm btn-dark'>DSR</a>

                                <a href='{{ route('admin.user_management.user.index_e') }}' class='btn btn-sm btn-dark'>All</a>

                                @endif

                            </h4>
                        </div>
                        <div class="col-6 text-right">

                            @if(isset($isCustom))

                            @if($isCustom === 'employees')

                            <a href="{{ route('admin.user_management.user.create.employee') }}" class="btn btn-sm btn-primary">New Employee</a>

                            @endif

                            @if($isCustom === 'customers')

                            <a href="{{ route('admin.user_management.user.create.customer') }}" class="btn btn-sm btn-primary">New Customer</a>

                            @endif


                            @else
                            <a href="{{ route('admin.user_management.user.create.customer') }}" class="btn btn-sm btn-primary">New Customer</a>

                            <a href="{{ route('admin.user_management.user.create.employee') }}" class="btn btn-sm btn-primary">New Employee</a>
                            @endif
                   
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <table class="table tablesorter ">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                              
                         
                                @if(!isset($isCustom))
                      
                                
                                <th>
                                    Departments
                                </th>
                                
                                @endif
                                
                                @if(isset($isCustom))
                                @switch($isCustom)
                                @case('employees')

                                <th>
                                    Name
                                </th>
                                <th>
                                    Category
                                </th>
                                <th>
                                    Mobile Number
                                </th>
                                
                                <th>
                                    Status
                                </th>

                                @break
                                @case('customers')
                                <th>
                                    Shop Name
                                </th>
                                <th>
                                    Mobile
                                </th>
                                <th>
                                    Address
                                </th>
                                <th>
                                    Status
                                </th>
                                @break
                                @endswitch
                                @endif
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $i=> $item)
                                <tr class="{{$item->status == 'blocked' ? ' bg-warning ' : '' }} {{$item->status == 'deleted' ? ' bg-danger ' : '' }}">
                                    <td>
                                        {{ $i+1 }}
                                    </td>
                                    
                              
                                    @if(!isset($isCustom))
                              

                                    <td>
                                        @forelse ($item->departments as $value)
                                            {{ $value->title }}
                                        @empty
                                            ----
                                        @endforelse
                                    </td>

                                    @endif
                                    
                                    @if(isset($isCustom))
                                    @switch($isCustom)
                                    @case('customers')
                                    <td>{{ $item->shop_name }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td>{{ $item->address }}</td>

                                    @break
                                    @case('employees')

                                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                                    <td>{{ $item->employee_type }}</td>
                                    <td>{{ $item->phone_number }}</td>

                                    @break
                                    @endswitch
                                    @endif

                                    <td>{{ $item->active_status }}</td>


                                    <td>
                                        @if ($item->status == 'deleted')
                                            <form action="{{ route('admin.user_management.user.restore', $item->id) }}" method="post" class="inline-block">
                                                @method('PUT')
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-link"><i class="tim-icons icon-pencil"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.user_management.user.edit', $item->id) }}" class="btn btn-link"><i class="tim-icons icon-pencil"></i></a>

                                            <form action="{{ route('admin.user_management.user.delete', $item->id) }}" method="post" class="inline-block">
                                                @method('DELETE')
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-link"><i class="tim-icons icon-simple-remove"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    
                </div>
              
            </div>
        </div>
    </div>
@endsection
