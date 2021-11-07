@extends('layouts.app', ['page' => 'Editing Complaint', 'pageSlug' => 'complaints', 'section' => 'tracking'])
@section('content')
<form method="post" action="{{ route('complaints.update', ['complaint' => $complaint->id]) }}" autocomplete="off">
                            @csrf
<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit Complaint</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('complaints.index') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>

               <div class='card-body'>

                    <input type='hidden' name='type' value='loan'>

                    @include('bst', [
                        'type' => 'textarea',

                        'settings' => [
                            'label' => 'Complaint',
                            'id' => 'complaint',
                            'placeholder' => 'Complaint...',
                            'value' => $complaint->complaint
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