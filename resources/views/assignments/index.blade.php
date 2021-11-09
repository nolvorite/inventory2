@extends('layouts.app', ['page' => 'List Of Assignments', 'pageSlug' => 'list', 'section' => 'assignments'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Assignments</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('assignments.create') }}" class="btn btn-sm btn-primary">New Assignment</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <th scope="col">ID</th>
                                <th>Assignee</th>
                                <th>Assigned Product</th>
                                <th>Quantity</th>
                 
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($assignments as $a)
                                <tr>
                                    <td>{{ $a->assignment_id }}</td>
                                    <td>{{ $a->assignee_name }}</td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->quantity }}</td>
                 
                                    <td class="td-actions text-right">
                                        <!-- <a href="{{ route('assignments.show', $a) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a> -->
                                        <a href="{{ route('assignments.edit', ['assignment' => $a->assignment_id]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Product">
                                            <i class="tim-icons icon-pencil"></i>
                                        </a>
                                        <form action="{{ route('assignments.destroy', ['assignment' => $a->assignment_id]) }}" method="post" class="d-inline">
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

