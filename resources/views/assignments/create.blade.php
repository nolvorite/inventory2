@extends('layouts.app', ['page' => 'New Assignment', 'pageSlug' => 'create', 'section' => 'assignment'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">New Assignment</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('assignments.index') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('assignments.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">Assignment Information</h6>
                            <div class="pl-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="assigned_to_id">Select Employee</label>

                                    <br>

                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="employee_company_selector" checked value="DSR">
                                      <label class="form-check-label" for="inlineRadio1">DSR</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="employee_company_selector" value="BP">
                                      <label class="form-check-label" for="inlineRadio2">BP</label>
                                    </div>

                                </div>                          

                                <div class="form-group{{ $errors->has('assigned_to_id') ? ' has-danger' : '' }}">
                                    <select class="form-select form-control-alternative" name="assigned_to_id">
                                        <option>Select...</option>
                                    	@foreach($assignees as $assignee)
                                    	<option value='{{ $assignee->id }}' company_desc='{{ $assignee->employee_type }}'>{{ $assignee->first_name }} {{ $assignee->last_name }} </option>
                                    	@endforeach
                                    </select>
                                </div>
                            
                            </div>

                            <div class="pl-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="product_id">Select Product</label>

                                    <br>

                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="company_selector" checked value="Robi">
                                      <label class="form-check-label" for="inlineRadio1">Robi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="company_selector" value="Airtel">
                                      <label class="form-check-label" for="inlineRadio2">Airtel</label>
                                    </div>

                                </div>
                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <select class="form-select form-control-alternative" name="product_id">
                                        <option>Select...</option>
                                    	@foreach($products as $product)
                                    	<option value='{{ $product->product_id }}'>

                                            {{ $product->company_name }} -- {{ $product->product_name }} -- {{ $product->price }} -- {{ $product->buying_date }}

                                        </option>
                                    	@endforeach
                                    </select>
                                </div>
                            </div>

                            @include('bst', [
                                'type' => 'input',
                                'settings' => [
                                    'value' => '',
                                    'id' => 'quantity',
                                    'placeholder' => 'Quantity Here',
                                    'label' => 'Quantity'
                                ]
                            ])

            

                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="product_id">Notes</label>
                                    <textarea class='form-control' name='notes'>{{ old("notes") }}</textarea>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">Submit</button>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
	
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

                        if(select.selected() === 'Select...'){
                            select.search($("input[name=employee_company_selector]:checked").val());
                        }

                        
                    };

                }

                if($(this).is("[name=product_id]")){

                    properties.afterOpen = function(){
                        if(select.selected() === 'Select...'){
                            select.search($("input[name=company_selector]:checked").val());
                        }
                  
                    };

                }

                console.log(properties);

                var select = new SlimSelect(properties);

            });
        })
    </script>

@endpush