@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Incomplete Tasks</h4></div>
                            <div class="col-md-6">
                                <a href="{{route('admin.actions.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new task</a>
                                @if ($authorizationUrl<>"NA")
                                    <a href="{{$authorizationUrl}}" class="btn btn-primary pull-right" style="margin-right:7px;"><i class="fa fa-plug"></i> Connect to Toodledo</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Project</th>
                                    <th>Assigned to</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Description</th>
                                    <th>Project</th>
                                    <th>Assigned to</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($actions as $action)
                                    <tr>
                                        <td><a href="{{route('admin.actions.edit',$action->id)}}">{{$action->description}}</a></td>
                                        <td><a href="{{route('admin.projects.show',$action->project_id)}}">{{$action->project->description}}</a></td>
                                        <td>
                                            <a href="{{route('admin.actions.edit',$action->id)}}">{{$action->user->individual->firstname}} {{$action->user->individual->surname}}</a>
                                        </td>
                                        <td><a title="Click to mark task as complete" href="#" class="btn btn-xs btn-default"><i class="fa fa-square-o"></i></a></td>
                                    </tr>
                                @empty
                                    <tr><td>No actions have been added yet</td></tr>
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
});
</script>
@endsection
