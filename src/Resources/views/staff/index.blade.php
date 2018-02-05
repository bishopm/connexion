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
                            <div class="col-md-12"><h4>Staff <small>with {{$thisyr}} leave taken to date</small></small></h4></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Staff Member</th><th>Job title</th><th>Annual leave</th><th>Sick leave</th><th>Family leave</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Staff Member</th><th>Job title</th><th>Annual leave</th><th>Sick leave</th><th>Family leave</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($staffs as $staff)
                                    <tr>
                                        <td><a href="{{route('admin.staff.show',$staff->slug)}}">{{$staff->firstname}} {{$staff->surname}}</a></td>
                                        <td><a href="{{route('admin.staff.show',$staff->slug)}}">
                                            @if ($staff->employee)
                                                {{$staff->employee->jobtitle}}</a>
                                            @endif
                                        </td>
                                        <td><a href="{{route('admin.staff.show',$staff->slug)}}">
                                            @if (isset($staff->leave['annual']))
                                                {{$staff->leave['annual']}}</a>
                                            @endif
                                        </td>
                                        <td><a href="{{route('admin.staff.show',$staff->slug)}}">
                                            @if (isset($staff->leave['sick']))
                                                {{$staff->leave['sick']}}</a>
                                            @endif
                                        </td>
                                        <td><a href="{{route('admin.staff.show',$staff->slug)}}">
                                            @if (isset($staff->leave['family']))
                                                {{$staff->leave['family']}}</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td>No staff members have been added yet</td></tr>
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