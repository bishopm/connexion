@extends('connexion::templates.backend')

@section('css')
    @parent
@stop

@section('content')
    <div class="container-fluid spark-screen">
        @include('connexion::shared.settings-modal')
        @include('connexion::shared.errors') 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Societies</h4></div>
                            <div class="col-md-6">
                                <a style="margin-left:10px;" href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#settingsModal">Settings</a>
                                @if ($setting['church_api_token'])
                                    <a href="{{route('admin.societies.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new society</a>
                                @else
                                    <a href="{{route('admin.mcsa.register')}}" class="btn btn-primary pull-right">Connect to MCSA database</a>
                                @endif
                            </div>
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
                                                @if ($setting['church_api_token'])
                                                    <a href="{{ route('admin.societies.edit', [$society->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.societies.destroy', [$society->id]) }}" data-action-entity="Society: {{$society->society}}"><i class="fa fa-trash"></i></button>
                                                @endif
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
@parent
<script language="javascript">
@include('connexion::shared.delete-modal-script') 
$(document).ready(function() {
        $('#indexTable').DataTable();
    } );
</script>
@endsection