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
                            <div class="col-md-6"><h4>Inactive users</h4></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td><a href="{{url('/')}}/admin/users/activate/{{$user->id}}"><i class="fa fa-plug"></i> Activate</a></td>
                                        <td>{{$user->individual->title ?? ''}} {{$user->individual->firstname ?? ''}} {{$user->individual->surname ?? ''}}</td>
                                        <td>{{$user->individual->cellphone ?? ''}}</td>
                                        <td>{{$user->email ?? ''}}</td>
                                    </tr>
                                @empty
                                    <tr><td>There are currently no inactive users</td></tr>
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