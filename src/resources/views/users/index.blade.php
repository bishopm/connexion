@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Users</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.users.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new user</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td><a href="{{route('admin.users.edit',$user->id)}}">{{$user->name}}</a></td>
                                        <td><a href="{{route('admin.users.edit',$user->id)}}">{{$user->email}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No users have been added yet</td></tr>
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