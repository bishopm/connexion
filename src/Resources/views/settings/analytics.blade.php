@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    <h2>Google Analytics</h2>
                </div>
                <div class="box-body">
                    <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Page</th>
                                <th>Views</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($analytics as $analytic)
                                <tr>
                                    <td>{{$analytic['url']}}</td>
                                    <td>{{$analytic['pageViews']}}</td>
                                </tr>
                            @empty
                                <tr><td>No data has been added yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script language="javascript">
$(document).ready(function() {
        $('#indexTable').DataTable( {
            "order": [[ 1, "desc" ]]
        } );
    } );
</script>
@endsection