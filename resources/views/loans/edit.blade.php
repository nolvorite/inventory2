@extends('layouts.app', ['page' => 'Modifying Loan', 'pageSlug' => 'list', 'section' => 'loans'])
@section('content')

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-lg-7">

                @include('alerts.success')


                <form method="post" action="{{ route('loans.update', ['loan' => $loan->id]) }}" autocomplete="off">
                    @csrf
                    @method('PUT')




            	<div class="card">
            	<div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Modifying Loan</h3>
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
                            'placeholder' => 'Loaner Name Here...',
                            'value' => $loan->loaner_name
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'type' => 'number',
                            'label' => 'Loan Amount',
                            'id' => 'loan_amount',
                            'placeholder' => 'Loan Amount Here...',
                            'value' => $loan->loan_amount,
                            'attributes' => 'disabled'
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'label' => 'Assigned Date',
                            'id' => 'assigned_date',
                            'placeholder' => 'Date Assigned...',
                            'classes' => 'datetimed',
                            'value' => $loan->assigned_date
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'label' => 'Loan Due Date',
                            'id' => 'loan_due_date',
                            'placeholder' => 'Loan Due Date...',
                            'classes' => 'datetimed',
                            'value' => $loan->loan_due_date
                        ]
                    ])

                <div class="text-center">
                    <button type="submit" class="btn btn-success mt-4">Submit</button>
                </div>

            </div>

	   </div>
</form>
</div>

<div class="col-lg-5">

    <div class="card">
        <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Payments</h3>
                    </div>
                
                </div>
            </div>

        <div cslass='card-body'>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                <div class="form-group">
                 <b>Payment Details:</b>
                 <ul>
                    <li>Currently Paid: <span id='currently_paid'>{{ $loan->amount_paid }}</span></li>
                    <li>Remaining: <span id='remaining'>{{ $loan->amount_remaining }}</span></li></ul>
                </div>
                </div>
            </div>
        </div>           

        </div>

    </div>

    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-8">
                    <h3 class="mb-0">New Payment</h3>
                </div>
           
            </div>
        </div>

       <div class='card-body'>
            
            <form method="post" action="{{ route('loan_payments.store') }}" autocomplete="off">
                @csrf

            <input type='hidden' value='{{ $loan->id }}' name='loan_id'>

            @include('bst', [
                'type' => 'input',

                'settings' => [
                    'type' => 'number',
                    'label' => 'Payment Amount',
                    'id' => 'payment_amount',
                    'placeholder' => 'Payment Amount Here...',
                    'attributes' => 'max='. $loan->amount_remaining 
                ]
            ])

            @include('bst', [
                'type' => 'input',

                'settings' => [
                    'label' => 'Paid At',
                    'id' => 'payment_date',
                    'placeholder' => 'Paid At...',
                    'classes' => 'datetimed'
                ]
            ])


            <div class="text-center">
                <button type="submit" class="btn btn-success mt-4">Submit</button>
            </div>

        </form>

        </div>

    </div>

    <div class="card">
        <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Payment History</h3>
                    </div>
                
                </div>
            </div>

        <div class='card-body' id='payment_history'>

            @foreach($payments as $lp)

                <div class='card payment-card'>
                    
                    <div class='card-body'>
                        <div class="float-right"><form action="{{ route('loan_payments.destroy', ['loan_payment' => $lp->id]) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Delete Loan Payment" onclick="confirm('Are you sure you want to remove this loan payment? The records that contain it will continue to exist.') ? this.parentElement.submit() : ''">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </form></div>
                        <ul><li><b>Amount: </b> {{ $lp->payment_amount }}</li>
                        <li><b>Date: </b> {{ $lp->payment_date }}</li>
                    </ul>

                    
                    </div>
                    
                </div>

            @endforeach

        </div>

    </div>
    
    

</div>

</div>



</div></div>

@endsection
@push('js')

    <style type='text/css'>
        #payment_history{max-height: 350px;overflow: auto;min-height: 250px}
        .card.payment-card{background: #e0e0e0!important;}
        .payment-card form{margin-right: 0; margin-top: 0}
        .payment-card ul{width: calc(100% - 50px);}
        .payment-card .float-right {
            margin-top: -13px;
            margin-right: -10px;
        }
    </style>
	
	<script type="text/javascript">
        $(document).ready(function(){
            $('.form-select').each(function(e){
                var properties = {
                    select: $(this)[0]
                }
                var select = new SlimSelect(properties);

            });
            $(".datetimed").datetimepicker({timepicker:false, format: 'd M Y'});

        })
    </script>

@endpush