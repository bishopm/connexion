@extends('adminlte::page')

@section('content')
@include('connexion::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Societies</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.societies.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new society</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Society</th>
                                    <th>Services</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Society</th>
                                    <th>Services</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($societies as $society)
                                    <tr>
                                        <td><a href="{{route('admin.societies.show',$society->id)}}">{{$society->society}}</a></td>
                                        <td>{{count($society->services)}}
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.societies.edit', [$society->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.societies.destroy', [$society->id]) }}" data-action-entity="Society: {{$society->society}}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td>No societies have been added yet</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('connexion::shared.delete-modal') 
@endsection
@section('js')
<script language="javascript">
@include('connexion::shared.delete-modal-script') 
$(document).ready(function() {
        $('#indexTable').DataTable();
    } );
</script>
@endsection