@extends('connexion::templates.backend')

@section('css')
    @parent
@stop

@section('content')
    <div class="container-fluid spark-screen">
    @include('connexion::shared.errors') 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Groups</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.groups.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new group</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Group name</th><th>Members</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Group name</th><th>Members</th><th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($groups as $group)
                                    <tr>
                                        <td><a href="{{route('admin.groups.show',$group->id)}}">{{$group->groupname}}</a></td>
                                        <td><a href="{{route('admin.groups.show',$group->id)}}">{{count($group->individuals)}}</a></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.groups.edit', [$group->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.groups.destroy', [$group->id]) }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td>No groups have been added yet</td></tr>
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