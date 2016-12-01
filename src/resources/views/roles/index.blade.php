@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Roles</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.roles.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new role</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Display name</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Role</th>
                                    <th>Display name</th>
                                    <th>Description</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr>
                                        <td><a href="{{route('admin.roles.show',$role->id)}}">{{$role->name}}</a></td>
                                        <td><a href="{{route('admin.roles.show',$role->id)}}">{{$role->display_name}}</a></td>
                                        <td><a href="{{route('admin.roles.show',$role->id)}}">{{$role->description}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No roles have been added yet</td></tr>
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