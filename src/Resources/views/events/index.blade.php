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
                            <div class="col-md-6"><h4>Events</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.events.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new event</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Event name</th><th>Participants</th><th>Event date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Event name</th><th>Participants</th><th>Event date</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($events as $event)
                                    <tr>
                                        <td><a href="{{route('admin.events.show',$event->id)}}">{{$event->groupname}}</a></td>
                                        <td><a href="{{route('admin.events.show',$event->id)}}">{{count($event->individuals)}}</a></td>
                                        <td>
                                            <a href="{{route('admin.events.show',$event->id)}}">{{date("Y-m-d H:i",$event->eventdatetime)}}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td>No events have been added yet</td></tr>
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