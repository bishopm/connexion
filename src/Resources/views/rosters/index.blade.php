@extends('adminlte::page')

@section('content')
@include('connexion::shared.errors') 

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"><h4>Rosters</h4></div>
                        <div class="col-md-6"><a href="{{route('admin.rosters.create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add a new roster</a></div>
                        <hr>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Roster name</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Roster name</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($rosters as $roster)
                                <tr>
                                    <td><a href="{{url('/')}}/admin/rosters/{{$roster->id}}/{{date('Y')}}/{{date('n')}}">{{$roster->rostername}}</a></td>
                                </tr>
                            @empty
                                <tr><td>No rosters have been added yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
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