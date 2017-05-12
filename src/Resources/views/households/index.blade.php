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
                            <div class="col-md-6"><h4>Households</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.households.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new household</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Surname</th>
                                    <th>Household</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Surname</th>
                                    <th>Household</th>
                                    <th>Address</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($households as $household)
                                    <tr>
                                        <td><a href="{{route('admin.households.show',$household->id)}}">{{$household->sortsurname}}</a></td>
                                        <td><a href="{{route('admin.households.show',$household->id)}}">{{$household->addressee}}</a></td>
                                        <td><a href="{{route('admin.households.show',$household->id)}}">{{$household->addr1}}</a></td>
                                    </tr>
                                @endforeach
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
    $('#indexTable').DataTable( 
        {
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                }
            ],
            "oLanguage": {
                "sEmptyTable": "No households have been added yet"
            },
        }
    );
});
</script>
@endsection
