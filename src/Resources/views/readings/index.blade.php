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
                            <div class="col-md-6"><h4>Readings</h4></div>
                            <div class="col-md-6">
                                <span class="pull-right">
                                    <a href="{{route('admin.readings.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add a new reading</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th><th>Description</th><th>Readings</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th><th>Description</th><th>Readings</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($readings as $reading)
                                    <tr>
                                        <td><a href="{{route('admin.readings.edit',$reading->id)}}">{{$reading->readingdate}}</a></td>
                                        <td><a href="{{route('admin.readings.edit',$reading->id)}}">{{$reading->description}}</a></td>
                                        <td><a href="{{route('admin.readings.edit',$reading->id)}}">{{$reading->readings}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No readings have been added yet</td></tr>
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