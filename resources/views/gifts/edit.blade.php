@extends('layouts.app', ['page' => 'Editing Gift', 'pageSlug' => 'list', 'section' => 'gifts'])
@section('content')
<form method="post" action="{{ route('gifts.update', ['gift' => $gift->id]) }}" autocomplete="off">
    @csrf
    @method('put')
<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
            	<div class="card">
            	<div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit Gift</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('gifts.index') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>

               <div class='card-body'>
               		@include('bst', [
                        'type' => 'select',

                        'settings' => [
                        	'label' => 'Customer Name',
                            'id' => 'customer_id',
                            'data' => $customers,
                            'valueCol' => 'id',
                            'displayCol' => 'customer_name',
                            'defaultSelected' => $gift->customer_id,
                            'attributes' => 'disabled'
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                            'label' => 'Assigned By',
                            'id' => 'assigned_by',
                            'value' => $gift->employee_name,
                            'attributes' => "disabled"
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                        	'label' => 'Gift Name',
                            'id' => 'gift_label',
                            'placeholder' => 'Gift Name Here...',
                            'value' => $gift->gift_label
                        ]
                    ])

                    @include('bst', [
                        'type' => 'input',

                        'settings' => [
                        	'label' => 'Delivery Date',
                            'id' => 'delivery_date',
                            'placeholder' => 'Gift Name Here...',
                            'classes' => 'datetimed',
                            'value' => $gift->delivery_date
                        ]
                    ])

                    @include('bst', [
                        'type' => 'select',

                        'settings' => [
                            'label' => 'Delivery Status',
                            'id' => 'status',
                            'data' => [
                                ['value' => 'pending' , 'display' => 'Pending'],
                                ['value' => 'processing' , 'display' => 'Processing'],
                                ['value' => 'delivered', 'display' => 'Delivered'],
                            ],
                            'defaultSelected' => $gift->status,
                            'valueCol' => 'value',
                            'displayCol' => 'display'
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