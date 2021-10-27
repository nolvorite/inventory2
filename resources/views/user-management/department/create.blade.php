@extends('layouts.app', ['page' => 'Create New Department', 'pageSlug' => 'departments', 'section' => 'users'])

@section('content')
    <div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            {{-- <h4 class="card-title">Create new permission</h4> --}}
            <form class="forms-sample" method="POST" action="{{ route('admin.user_management.department.store') }}">
                {!! csrf_field() !!}

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Title like: Client">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="parent">Parent</label>
                            <select class="form-control" name="parent_id" id="parent" placeholder="Select department">
                                <option></option>
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>
                </div>
              
                <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                <a href="{{ route('admin.user_management.department.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
