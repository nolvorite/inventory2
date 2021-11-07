@extends('layouts.app', ['page' => 'Product Types', 'pageSlug' => 'categories', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Product Types <a href='{{ route('categories.index') }}?filter=robi' class='btn btn-sm btn-dark'>Robi</a><a href='{{ route('categories.index') }}?filter=airtel' class='btn btn-sm btn-dark'>Airtel</a><a href='{{ route('categories.index') }}' class='btn btn-sm btn-dark'>All</a></h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">New Product Type</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">Company</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <!-- <th scope="col">Defective Stock</th> -->
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->company_name }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>

                                            <input class='toggles' type="checkbox" url='{{ route('products.switch_status') }}?category_id={{ $category->id }}' data-width="100" data-onstyle=success {{ $category->product_status === 'active' ? ' checked ' : '' }} data-toggle="toggle" data-size="xs">

                                            </td>
                                        <!-- <td>{{ $category->products->sum('stock_defective') }}</td> -->
                   
                                        <td class="td-actions text-right">
                                            <a href="{{ route('categories.show', $category) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Category">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Category" onclick="confirm('Are you sure you want to delete this category? All products belonging to it will be deleted and the records that contain it will not be accurate.') ? this.parentElement.submit() : ''">
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
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $categories->links() }}
                    </nav>
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
