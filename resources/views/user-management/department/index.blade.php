@extends('layouts.app', ['page' => 'User Types', 'pageSlug' => 'departments', 'section' => 'employees'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">User Types</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.user_management.department.create') }}" class="btn btn-sm btn-primary">New User Type</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Title
                                </th>
                                <th>
                                    Parent
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $item)
                                <tr>
                                    <td>
                                    {{ $item->id }}
                                    </td>
                                    <td>
                                        {{ $item->title }}
                                    </td>
                                    <td>
                                        {{  $item->parent ? $item->parent->title : '----' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user_management.department.edit', $item->id) }}" class="btn btn-outline-dark btn-sm">Edit</a>

                                        <form action="{{ route('admin.user_management.department.delete', $item->id) }}" method="post" class="inline-block">
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
@endsection
