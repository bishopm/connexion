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
                            <div class="col-md-6"><h4>Midweek services</h4></div>
                            <div class="col-md-6">
                                @if ($weekdays=="No token")
                                    <a href="{{route('admin.mcsa.register')}}" class="btn btn-primary pull-right">Connect to MCSA database</a>
                                @else
                                    <a href="{{route('admin.weekdays.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new service</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Midweek service</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Midweek service</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (is_array($weekdays))
                                    @forelse ($weekdays as $weekday)
                                        <tr>
                                            <td><a href="{{route('admin.weekdays.edit',$weekday->id)}}">{{date("d F Y",$weekday->servicedate)}}</a></td>
                                            <td><a href="{{route('admin.weekdays.edit',$weekday->id)}}">{{$weekday->description}}</a></td>
                                        </tr>
                                    @empty
                                        <tr><td>No midweek services have been added yet</td></tr>
                                    @endforelse
                                @endif
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