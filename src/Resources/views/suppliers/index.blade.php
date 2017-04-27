@extends('adminlte::page')

@section('content')
    <div class="container-fluid spark-screen">
    @include('connexion::shared.errors') 
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Book suppliers</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.suppliers.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new supplier</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Supplier</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Supplier</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td><a href="{{route('admin.suppliers.edit',$supplier->id)}}">{{$supplier->supplier}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No suppliers have been added yet</td></tr>
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