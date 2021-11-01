@extends('layouts.app', ['page' => 'New Category', 'pageSlug' => 'categories', 'section' => 'inventory'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">New Product Category</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('categories.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">Category Information</h6>
                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Name</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Name" value="{{ old('name') }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label" for="input-category-status">Category Status</label>
                                    <select class="form-control" name="product_status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
 
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label" for="input-category-status">Company Name</label>
                                    <select class="form-control" name="company_name">
                                        <option value="robi">Robi</option>
                                        <option value="airtel">Airtel</option>
                                    </select>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
