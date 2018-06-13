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
                            <div class="col-md-6"><h4>Preachers</h4></div>
                            <div class="col-md-6">
                                @if ($preachers=="No token")
                                    <a href="{{route('admin.mcsa.register')}}" class="btn btn-primary pull-right">Connect to MCSA database</a>
                                @else
                                    <a style="margin-left:10px;" href="{{route('admin.preachers.meeting',date('Y'))}}" class="btn btn-primary pull-right"><i class="fa fa-group"></i> Meeting register</a>
                                    <a href="{{route('admin.preachers.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new preacher</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Preacher</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Preacher</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(is_array($preachers))
                                    @forelse ($preachers as $preacher)
                                        <tr>
                                            <td><a href="{{route('admin.preachers.edit',$preacher->id)}}">{{$preacher->surname}}, {{$preacher->firstname}}</a></td>
                                            <td><a href="{{route('admin.preachers.edit',$preacher->id)}}">
                                            @foreach ($preacher->positions as $position)
                                                {{$position->position}}
                                            @endforeach
                                            </a></td>
                                        </tr>
                                    @empty
                                        <tr><td>No preachers have been added yet</td></tr>
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