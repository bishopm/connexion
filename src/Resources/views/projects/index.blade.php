@extends('connexion::templates.backend')

@section('css')
    @parent
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Projects</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.projects.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new project</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Project leader</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Description</th>
                                    <th>Project leader</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($projects as $project)
                                    <tr>
                                        <td><a href="{{route('admin.projects.show',$project->id)}}">{{$project->description}}</a></td>
                                        <td><a href="{{route('admin.projects.show',$project->id)}}">
                                            @if ($project->individual)
                                                {{$project->individual->firstname}} {{$project->individual->surname}}
                                            @else
                                                No leader assigned
                                            @endif
                                        </a></td>
                                    </tr>
                                @empty
                                    <tr><td>No projects have been added yet</td></tr>
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
@parent
<script language="javascript">
$(document).ready(function() {
        $('#indexTable').DataTable();
    } );
</script>
@endsection