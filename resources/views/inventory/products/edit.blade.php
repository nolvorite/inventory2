@extends('layouts.app', ['page' => 'Edit Product', 'pageSlug' => 'products', 'section' => 'inventory'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit Product</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        @if(count($errors) > 0)

    <div class="alert alert-warning">
        Some fields are missing input. Please make sure that all fields are filled out.
    </div>

    @endif

                        <form method="post" action="{{ route('products.update', $product) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <input name='name' value='/' type='hidden'>

                            <h6 class="heading-small text-muted mb-4">Product Information</h6>
                            <div class="pl-lg-4">

                                <div class="form-group">
                                    <label class="form-control-label" for="input-category-status">Company</label>
                                    <select class="form-control" name="company_name">
                                        <option value="robi"{{ $product->company_name === 'robi' ? ' selected' : '' }}>Robi</option>
                                        <option value="airtel"{{ $product->company_name === 'airtel' ? ' selected' : '' }}>Airtel</option>
                                    </select>
 
                                </div>

                                <div class="form-group{{ $errors->has('product_category_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Product Type</label>
                                    <select name="product_category_id" id="input-category" class="form-select form-control-alternative{{ $errors->has('product_type') ? ' is-invalid' : '' }}" required>
                                        @foreach ($categories as $category)
                                            @if($category['id'] == old('product_category_id',$product->product_category_id))
                                                <option value="{{$category['id']}}" selected>{{$category['name']}}</option>
                                            @else
                                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'product_category_id'])
                                </div>

                                <div class="form-group{{ $errors->has('product_quantity') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="product_quantity">Quantity</label>
                                    <input type="text" name="product_quantity" id="product_quantity" class="form-control form-control-alternative{{ $errors->has('product_quantity') ? ' is-invalid' : '' }}" placeholder="Describe how many quantity is contained in one stock." value="{{ old('product_quantity', $product->product_quantity) }}" required>

                                    @include('alerts.feedback', ['field' => 'product_quantity'])
                                </div> 

                                <div class="form-group{{ $errors->has('buying_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="buying_date">Buying Date</label>
                                    <input type="text" name="buying_date" id="buying_date" class="datetimed form-control form-control-alternative{{ $errors->has('buying_date') ? ' is-invalid' : '' }}" placeholder="Buying Date" value="{{ old('buying_date', $product->buying_date) }}" required>

                                    @include('alerts.feedback', ['field' => 'buying_date'])
                                </div>

                
                                <div class="row">
                                    <div class="col-md-4">                                    
                                        <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-stock">Stock</label>
                                            <input type="number" name="stock" id="input-stock" class="form-control form-control-alternative" placeholder="Stock" value="{{ old('stock', $product->stock) }}" required>
                                            @include('alerts.feedback', ['field' => 'stock'])
                                        </div>
                                    </div>    
                                    <input type="hidden" name="stock_defective" id="input-stock_defective" class="form-control form-control-alternative"  value="0" required>                        
                                    <!--<div class="col-4">                                    
                                        <div class="form-group{{ $errors->has('stock_defective') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-stock_defective">Defective Stock</label>
                                            <input type="number" name="stock_defective" id="input-stock_defective" class="form-control form-control-alternative" placeholder="Defective Stock" value="{{ old('stock_defective') }}" required>
                                            @include('alerts.feedback', ['field' => 'stock_defective'])
                                        </div>
                                    </div> -->
                                    <div class="col-md-4">                                    
                                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-price">Buying Price</label>
                                            <input type="number" step="1" name="price" id="input-price" class="form-control form-control-alternative" placeholder="Price" value="{{ old('price', $product->price) }}" required>
                                            @include('alerts.feedback', ['field' => 'price'])
                                        </div>
                                    </div>
                                    <div class="col-md-4">                                    
                                        <div class="form-group{{ $errors->has('selling_price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-selling-price">Selling Price</label>
                                            <input type="number" step="1" name="selling_price" id="input-selling-price" class="form-control form-control-alternative" placeholder="Price" value="{{ old('price', $product->selling_price) }}" required>
                                            @include('alerts.feedback', ['field' => 'selling_price'])
                                        </div>
                                    </div> 
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

@push('js')
    <script>
        select = new SlimSelect({
            select: '.form-select',
            afterOpen: function(){
                select.search($("select[name=company_name]").val())
            }
        })

        $("#buying_date").datetimepicker({timepicker:false, format:'d M Y'});
    </script>
@endpush