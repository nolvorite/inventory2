
@extends('layouts.app', ['page' => 'New Assignment', 'pageSlug' => 'create', 'section' => 'assignment'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit Assignment</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('assignments.index') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('assignments.update', ['assignment' => $assignment->assignment_id]) }}" autocomplete="off">
                            @csrf
                            @method('put')
                            <h6 class="heading-small text-muted mb-4">Assignment Information</h6>
                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('assigned_to_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="assigned_to_id">Person Assigned For This</label>
                                    <select disabled class="form-select form-control-alternative" name="assigned_to_id">
                                    	@foreach($assignees as $assignee)
                                    	<option value='{{ $assignee->id }}' {{ $assignment->assigned_to_id."" === $assignee->id."" ? " selected" : "" }} >{{ $assignee->first_name }} {{ $assignee->last_name }}</option>
                                    	@endforeach
                                    </select>
                                </div>
                            
                            </div>

                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="product_id">Product Assigned To This Person</label>
                                    <select disabled class="form-select form-control-alternative" name="product_id">
                                    	@foreach($products as $product)
                                    	<option value='{{ $product->product_id }}'{{ $assignment->product_id."" === $product->product_id."" ? " selected" : "" }}> {{ $product->company_name }} -- {{ $product->product_name }} -- {{ $product->price }} -- {{ $product->buying_date }}</option>
                                    	@endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('seller_price') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="seller_price">Seller Price</label>
                                    <input value='{{ old("seller_price", $assignment->seller_price) }}' class='form-control' name='seller_price' readonly type='number' placeholder='The price the employer will sell for.'>
                                </div>
                            </div>

                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="quantity">Quantity</label>
                                    <input value='{{ old("quantity", $assignment->assignment_quantity) }}' class='form-control' name='quantity' type='number'>
                                </div>
                            </div>

                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('quantity_sold') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="quantity_sold">Quantity Sold</label>
                                    <input disabled value='{{ old("quantity_sold", $assignment->quantity_sold) }}' class='form-control' name='quantity_sold' type='number'>
                                </div>
                            </div>

                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="notes">Notes </label>
                                    <textarea class='form-control' name='notes'>{{ old("notes", $assignment->notes) }}</textarea>
                                </div>
                            </div>

                            <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('return_status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="product_id">Return Status</label>
                                    <select class="form-select form-control-alternative" name="return_status">
                                    	<option value='returned'{{ $assignment->return_status."" === 'returned' ? " selected" : "" }}>Returned</option>
                                    	<option value='not_all_returned'{{ $assignment->return_status."" === 'not_all_returned' ? " selected" : "" }}>Returned (Incompletely)</option>
                                    	<option value='approved'{{ $assignment->return_status."" === 'approved' ? " selected" : "" }}>Approved</option>
                                    	<option value='sold'{{ $assignment->return_status."" === 'sold' ? " selected" : "" }}>Sold</option>
                                    </select>
                                </div>
                            </div>

                             <div class="pl-lg-12">
                                <div class="form-group{{ $errors->has('returned_amount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="returned_amount">Returned Amount</label>
                                    <input class='form-control' value='{{ old("returned_amount", $assignment->returned_amount) }}' name='returned_amount' type='number' placeholder='The total quantity returned by the employee.'>
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

                if($(this).is("[name=product_id]")){

                    properties.afterOpen = function(){
                        select.search($("input[name=company_selector]:checked").val());
                    };

                }

                var select = new SlimSelect(properties);

            });
        })
    </script>

@endpush