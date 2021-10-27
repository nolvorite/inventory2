@extends('layouts.app', ['page' => 'List Of Roles', 'pageSlug' => 'roles', 'section' => 'users'])

@section('content')
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    
                    <h4 class="card-title">List of roles <a href="{{ route('admin.user_management.role.create') }}" class="btn btn-sm btn-outline-primary btn-icon-text float-right btn-newInList">
                        <i class="mdi mdi-settings btn-icon-prepend"></i>
                        new role   
                    </a></h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Role Name
                                </th>
                                <th>
                                    Title
                                </th>
                                <th>
                                    guard name
                                </th>
                                <th>
                                    description
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $item)
                                <tr>
                                    <td>
                                        {{ $item->id }}
                                    </td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->title }}
                                    </td>
                                    <td>
                                        {{ $item->guard_name }}
                                    </td>
                                    <td>
                                        {{ $item->description }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user_management.role.edit', $item->id) }}" class="btn btn-outline-dark btn-sm">Edit</a>

                                        <form action="{{ route('admin.user_management.role.delete', $item->id) }}" method="post" class="inline-block">
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

@push('js')
    <script>
        $('.toggles').bootstrapToggle({
            on: 'active',
            off: 'inactive'
        }).on('change', function(){
            var url = $(this).attr('url');
            location.href = url;
        });
    </script>
@endpush
