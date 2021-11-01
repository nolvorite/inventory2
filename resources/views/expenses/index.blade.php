@extends('layouts.app', ['page' => 'Expenses', 'pageSlug' => 'list', 'section' => 'loans'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Expenses</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('loans.create') }}" class="btn btn-sm btn-primary">New Expense</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class="text-primary">
                                <th scope="col">ID</th>
                                <th>Expense Type</th>
                                <th>Amount Paid</th>
                                <th>Log Time</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($expenses as $e)
                                <tr>
                                    <td>{{ $e->id }}</td>
                                    <td>{{ $e->expense_type }}</td>
                                    <td>{{ $e->expense_amount }}</td>
                                    <td>{{ $e->log_time }}</td>
                                    <td class="td-actions text-right">
                
                                        <a href="{{ route('expenses.edit', ['expense' => $e->id]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Expense">
                                            <i class="tim-icons icon-pencil"></i>
                                        </a>
                                        <form action="{{ route('expenses.destroy', ['expense' => $e->id]) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Expense" onclick="confirm('Are you sure you want to remove this expense? The records that contain it will continue to exist.') ? this.parentElement.submit() : ''">
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

