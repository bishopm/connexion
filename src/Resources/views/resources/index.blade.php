@extends('adminlte::page')

@section('content')
@include('base::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Resources</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.resources.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new resource</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Slide</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Slide</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($resources as $resource)
                                    <tr>
                                        <td><a href="{{route('admin.resources.edit',$resource->id)}}">{{$resource->title}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No resources have been added yet</td></tr>
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