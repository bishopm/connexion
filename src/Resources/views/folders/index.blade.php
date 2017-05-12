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
                            <div class="col-md-6"><h4>Folders</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.folders.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new folder</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Folder</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Folder</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($folders as $folder)
                                    <tr>
                                        <td><a href="{{route('admin.folders.edit',$folder->id)}}">{{$folder->folder}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No folders have been added for your user yet</td></tr>
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