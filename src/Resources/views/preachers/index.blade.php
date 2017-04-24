@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
    @include('connexion::shared.errors') 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Preachers</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.preachers.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new preacher</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Preacher</th>
                                    <th>Society</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Preacher</th>
                                    <th>Society</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($preachers as $preacher)
                                    <tr>
                                        <td><a href="{{route('admin.preachers.edit',$preacher->id)}}">{{$preacher->firstname}} {{$preacher->surname}}</a></td>
                                        <td>
                                        @if (($preacher->status<>"Minister") and ($preacher->status<>"Guest"))
                                            <a href="{{route('admin.preachers.edit',$preacher->id)}}">{{$preacher->society->society}}</a>
                                        @endif
                                        </td>
                                        <td><a href="{{route('admin.preachers.edit',$preacher->id)}}">{{$preacher->status}}</a></td>

                                    </tr>
                                @empty
                                    <tr><td>No preachers have been added yet</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script language="javascript">
$(document).ready(function() {
        $('#indexTable').DataTable();
    } );
</script>
@endsection