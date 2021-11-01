@extends('layouts.app', ['page' => 'Add New Gift Record', 'pageSlug' => 'list', 'section' => 'gifts'])
@section('content')
<form method="post" action="{{ route('gifts.store') }}" autocomplete="off">
                            @csrf
<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
            	<div class="card">
            	<div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">New Gift</h3>
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
        	'label' => 'Select Customer',
            'id' => 'customer_id',
            'data' => $customers,
            'valueCol' => 'id',
            'displayCol' => 'customer_name'
        ]
    ])

    @include('bst', [
        'type' => 'input',

        'settings' => [
        	'label' => 'Gift Name',
            'id' => 'gift_label',
            'placeholder' => 'Gift Name Here...'
        ]
    ])

    @include('bst', [
        'type' => 'input',

        'settings' => [
        	'label' => 'Delivery Date',
            'id' => 'delivery_date',
            'placeholder' => 'Gift Name Here...',
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
           $(".datetimed").datetimepicker({timepicker:false});

        })
    </script>

@endpush