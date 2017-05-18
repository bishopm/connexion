@extends('connexion::worship.page')

@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Sets <small>{{$society}}</small></h4></div>
                            <div class="col-md-6"><a href="{{route('admin.sets.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new set</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date of service</th>
                                    @foreach ($services as $service)
                                        <th>{{$service}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date of service</th>
                                    @foreach ($services as $service)
                                        <th>{{$service}}</th>
                                    @endforeach
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($sets as $key=>$set)                           
                                    <tr>
                                        <td>{{date("d M Y",$key)}}</td>
                                        @foreach ($set as $ss)
                                            <td>
                                                @if($ss<>"")
                                                    <a href="{{route('admin.sets.show',$ss)}}">Edit set</a>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr><td>No sets have been added yet</td></tr>
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
@include('connexion::worship.partials.scripts')
<script src="//cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
<script language="javascript">
$('#indexTable').DataTable(
    {
        "order": [[ 0, "desc" ]]
    }
);
</script>
@endsection