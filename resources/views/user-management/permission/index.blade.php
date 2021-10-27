@extends('layouts.app', ['page' => 'Product Types', 'pageSlug' => 'permissions', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Permissions</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.user_management.permission.create') }}" class="btn btn-sm btn-primary">New Permission</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Permission Name
                                </th>
                                <th>
                                    Title
                                </th>
                                <th>
                                    Guard name
                                </th>
                                <th>
                                    description
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $item)
                                <tr>
                                    <td>
                                        {{ $item->id }}
                                    </td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->title ??'--'  }}
                                    </td>
                                    <td>
                                        {{ $item->guard_name }}
                                    </td>
                                    <td>
                                        {{ $item->description }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user_management.permission.edit', $item->id) }}" class="btn btn-outline-dark btn-sm">Edit</a>

                                        <form action="{{ route('admin.user_management.permission.delete', $item->id) }}" method="post" class="inline-block">
                                            @method('DELETE')
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
             
            </div>
        </div>
    </div>
@endsection
