@extends('layouts.app', ['page' => 'Dues', 'pageSlug' => 'list', 'section' => 'loans'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Dues</h4>
                        </div>
 
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class="text-primary">
                                <th scope="col">ID</th>
                                <th>Source Name</th>
                                <th>Due Amount</th>
                                <th>Assigned Date</th>
                                <th>Due Date</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($loans as $l)
                                <tr>
                                    <td>{{ $l->id }}</td>
                                    <td>{{ $l->loaner_name }}</td>
                                    <td>{{ $l->loan_amount }}</td>
                                    <td>{{ $l->assigned_date }}</td>
                                    <td>{{ $l->loan_due_date }}</td>

                                    <td class="td-actions text-right">
                
                                        <a href="{{ route('loans.edit', ['loan' => $l->id]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Loan">
                                            <i class="tim-icons icon-pencil"></i>
                                        </a>
                                        <form action="{{ route('loans.destroy', ['loan' => $l->id]) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Loan" onclick="confirm('Are you sure you want to remove this loan? The records that contain it will continue to exist.') ? this.parentElement.submit() : ''">
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

