@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Societies</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.societies.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new society</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Society</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Society</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($societies as $society)
                                    <tr>
                                        <td><a href="{{route('admin.societies.edit',$society->id)}}">{{$society->society}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No societies have been added yet</td></tr>
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