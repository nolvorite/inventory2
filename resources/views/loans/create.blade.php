@extends('layouts.app', ['page' => 'Add New Loan Record', 'pageSlug' => 'list', 'section' => 'loans'])
@section('content')
<form method="post" action="{{ route('loans.store') }}" autocomplete="off">
                            @csrf
<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
            	<div class="card">
            	<div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">New Loan</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('loans.index') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>

               <div class='card-body'>
               		@include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'label' => 'Source Name',
                            'id' => 'loaner_name',
                            'placeholder' => 'Loaner Name Here...'
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'type' => 'number',
                            'label' => 'Loan Amount',
                            'id' => 'loan_amount',
                            'placeholder' => 'Loan Amount Here...'
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'label' => 'Assigned Date',
                            'id' => 'assigned_date',
                            'placeholder' => 'Date Assigned...',
                            'classes' => 'datetimed'
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'label' => 'Loan Due Date',
                            'id' => 'loan_due_date',
                            'placeholder' => 'Loan Due Date...',
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
            $(".datetimed").datetimepicker({timePicker:true});

        })
    </script>

@endpush