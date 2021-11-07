@extends('layouts.app', ['page' => 'Add New Gift Record', 'pageSlug' => 'list', 'section' => 'expenses'])
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


    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="employee_company_selector" checked value="DSR">
      <label class="form-check-label" for="inlineRadio1">DSR</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="employee_company_selector" value="BP">
      <label class="form-check-label" for="inlineRadio2">BP</label>
    </div>

    @include('bst', [
        'type' => 'select',

        'settings' => [
            'label' => 'Select Employee',
            'id' => 'assigned_to_id',
            'data' => $employees,
            'valueCol' => 'user_id',
            'displayCol' => 'name'
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
        
           $(".datetimed").datetimepicker({timepicker:false});

        })

    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.form-select').each(function(e){
                var properties = {
                    select: $(this)[0]
                }

                if($(this).is("[name=assigned_to_id]")){

                    var optionData = [];

                    $(this).find("option").each(function(){

                        optionData.push({innerHTML: $(this).html() + " <span class='d-none'>" + $(this).attr('company_desc')+"</span>", text: $(this).text(), value: $(this).attr('value')});

                    });

                    properties.data = optionData;

                    properties.valuesUseText = false;

                    properties.afterOpen = function(){

                        select.search($("input[name=employee_company_selector]:checked").val());

                    };

                }

                console.log(properties);

                var select = new SlimSelect(properties);

            });
        })
    </script>

@endpush