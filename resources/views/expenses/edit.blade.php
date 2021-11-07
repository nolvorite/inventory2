@extends('layouts.app', ['page' => 'Add New Loan Record', 'pageSlug' => 'list', 'section' => 'expenses'])
@section('content')
<form method="post" action="{{ route('expenses.store') }}" autocomplete="off">
                            @csrf
<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
            	<div class="card">
            	<div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">New Expense</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('loans.index') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>

               <div class='card-body'>

                    @include('bst', [
                        'type' => 'select',

                        'settings' => [
                            'label' => 'Expense Type',
                            'id' => 'expense_type',
                            'defaultSelected' => $expense->expense_type,
                            'data' => [
                                ['value' => 'transport' , 'display' => 'Transport'],
                                ['value' => 'fuel' , 'display' => 'Fuel'],
                                ['value' => 'stationary' , 'display' => 'Stationary'],   
                            ]
                        ]
                    ])

               		@include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'label' => 'Expense Amount',
                            'id' => 'expense_amount',
                            'type' => 'number',
                            'placeholder' => 'Expense Amount Here...'
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'label' => 'Date Paid',
                            'id' => 'date_paid',
                            'placeholder' => 'Date Paid Here...',
                            'classes' => 'datetimed'
                        ]
                    ])

                <div class="text-center">
                    <button type="submit" class="btn btn-success mt-4">Submit</button>
                </div>

            </div>

	   </div>

</div></div></div>
</form>
@endsection
@push('js')
	
	<script type="text/javascript">
        $(document).ready(function(){
            $('.form-select').each(function(e){
                var properties = {
                    select: $(this)[0]
                }
                var select = new SlimSelect(properties);

            });
            $(".datetimed").datetimepicker({timepicker:false, format:'Y/m/d'});

        })
    </script>

@endpush