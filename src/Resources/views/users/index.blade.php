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
                                    <th>Role</th>
                                    <th>Verified</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Verified</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td><a href="{{route('admin.users.edit',$user->id)}}">
                                            @if($user->individual_id)
                                                {{$user->individual->firstname}} {{$user->individual->surname}}
                                            @else
                                                {{$user->name}}
                                            @endif
                                        </a></td>
                                        <td><a href="{{route('admin.users.edit',$user->id)}}">{{$user->email}}</a></td>
                                        <td><a href="{{route('admin.users.edit',$user->id)}}">{{$user->roles()->first()->name}}</a></td>
                                        <td>@if ($user->verified)
                                                <i class="fa fa-check"></i>
                                            @else
                                                <i class="fa fa-times"></i>
                                            @endif
                                        </td>
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
@parent
<script language="javascript">
$(document).ready(function() {
    $('#indexTable').DataTable();
} );
</script>
@endsection 