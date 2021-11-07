@extends('layouts.app', ['page' => 'List of Products', 'pageSlug' => 'products', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Products <a href='{{ route('products.index') }}?filter=robi' class='btn btn-sm btn-dark'>Robi</a><a href='{{ route('products.index') }}?filter=airtel' class='btn btn-sm btn-dark'>Airtel</a><a href='{{ route('products.index') }}' class='btn btn-sm btn-dark'>All</a></h4>

                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">New product</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">Company Name</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Buy Price</th>
                                <th scope="col">Buying Date</th>

                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>


                                        <td>{{ ucfirst($product->company_name) }}</td>

                                        <td><a href='?category_id={{ $product->category->id }}'>{{ $product->category->name }}</a></td>

                                        <td width='1%'>{{ $product->stock }}</td>

                                        <td>{{ $product->price }}</td>

                                        <td>{{ $product->buying_date }}</td>
 
                                        <td class="td-actions text-right">
                    
                                            <a href="{{ route('products.edit', ['product' => $product->product_id]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Product">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Product" onclick="confirm('Are you sure you want to remove this product? The records that contain it will continue to exist.') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
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

