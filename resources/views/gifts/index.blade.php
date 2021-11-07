@extends('layouts.app', ['page' => 'Assigned Gifts', 'pageSlug' => 'list', 'section' => 'tracking'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Gifts</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('gifts.create') }}" class="btn btn-sm btn-primary">New Gift</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class="text-primary">
                                <th scope="col">ID</th>
                                <th>Customer Name</th>
                                <th>Assigned To</th>
                                <th>Product</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($gifts as $g)
                                <tr>
                                    <td>{{ $g->gift_id }}</td>
                                    <td>{{ $g->customer_name }}</td>
                                    <td>{{ $g->assigned_to_name }}</td>
                                    <td>{{ $g->gift_label }}</td>
                                    <td>{{ $g->delivery_date }} </td>
                                    <td>{{ $g->status }}</td>

                                    <td class="td-actions text-right">
                
                                        <a href="{{ route('gifts.edit', ['gift' => $g->gift_id]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Gift">
                                            <i class="tim-icons icon-pencil"></i>
                                        </a>
                                        <form action="{{ route('gifts.destroy', ['gift' => $g->gift_id]) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Gift" onclick="confirm('Are you sure you want to remove this gift? The records that contain it will continue to exist.') ? this.parentElement.submit() : ''">
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

