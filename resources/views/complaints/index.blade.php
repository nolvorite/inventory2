@extends('layouts.app', ['page' => 'Complaints', 'pageSlug' => 'complaints', 'section' => 'tracking'])

@section('content')
<div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Complaints</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('complaints.create') }}" class="btn btn-sm btn-primary">New Complaint</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class="text-primary">
                                <th scope="col">ID</th>
                                <th>Complaint</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach($complaints as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td>{{ $c->complaint }}</td>
                                    <td class="td-actions text-right">
                
                                        <a href="{{ route('complaints.edit', ['complaint' => $c->id]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Complaint">
                                            <i class="tim-icons icon-pencil"></i>
                                        </a>
                                        <form action="{{ route('complaints.destroy', ['complaint' => $c->id]) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Complaint" onclick="confirm('Are you sure you want to remove this complaint? The records that contain it will continue to exist.') ? this.parentElement.submit() : ''">
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

