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
                        <div class="col-md-6"><h4>Permissions</h4></div>
                        <div class="col-md-6"><a href="{{route('admin.permissions.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new permission</a></div>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Permission</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Permission</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr>
                                    <td><a href="{{route('admin.permissions.edit',$permission->id)}}">{{$permission->name}}</a></td>
                                </tr>
                            @empty
                                <tr><td>No permissions have been added yet</td></tr>
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