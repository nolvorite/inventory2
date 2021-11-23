@extends('layouts.app', ['page' => 'Complaints', 'pageSlug' => 'complaints', 'section' => 'tracking'])



@section('content')
<div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Complaints {!! $pagination !!}</h4>
                        </div>
                      
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="">
                        <table class="table tablesorter " id="">
                            <thead class="text-primary">
                                <th scope="col">#</th>
                                <th scope="col">Shop Name</th>
                                <th>Complaint</th>
                                <th>Reply</th>
                            </thead>
                            <tbody>
                                @foreach($complaints as $i => $c)
                                <?php
                                    $complaint = (strlen($c->complaint) > 203) ? substr($c->complaint,0,200).'...' : $c->complaint;
                                    $adminReply = (strlen($c->admin_reply) > 203) ? substr($c->admin_reply,0,200).'...' : $c->admin_reply;
                                ?>
                                <tr>
                                    <td>{{ ($i+1) }}</td>
                                    <td>{{ $c->shop_name }}<br>{{ $c->complainant }}</td>
                                    <td><small>{{ $c->create_date }}</small><div style='width: 300px'>{{ $complaint }}</div></td>
                                    <td><small>{{ $c->reply_date }}</small><div style='width: 300px'>{!! $c->admin_reply !== null ? $adminReply : '(no reply yet)' !!}</div></td>
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
@push('js')
    <style>nav{display: inline-block;margin-left: 10px}</style>
@endpush