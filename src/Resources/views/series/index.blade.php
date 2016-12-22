@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Sermons preached at {{$setting['site_abbreviation']}}</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.series.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new series</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Series name</th>
                                    <th data-sortable="false">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Series name</th>
                                    <th data-sortable="false">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($series as $serie)
                                    <tr>
                                        <td><a href="{{route('admin.series.show',$serie->id)}}">{{$serie->series}}</a>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.series.edit', [$serie->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.series.destroy', [$serie->id]) }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td>No series has been added yet</td></tr>
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