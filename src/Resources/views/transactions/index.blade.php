@extends('connexion::templates.backend')

@section('css')
    @parent
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6"><h4>Transactions</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.transactions.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new transaction</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th><th>Details</th><th>Type</th><th>Book</th><th>Amount</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th><th>Details</th><th>Type</th><th>Book</th><th>Amount</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td><a href="{{route('admin.transactions.edit',$transaction->id)}}">{{$transaction->transactiondate}}</a></td>
                                        <td><a href="{{route('admin.transactions.edit',$transaction->id)}}">{{$transaction->details}}</a></td>
                                        <td><a href="{{route('admin.transactions.edit',$transaction->id)}}">{{$transaction->transactiontype}}</a></td>
                                        <td><a href="{{route('admin.transactions.edit',$transaction->id)}}">{{$transaction->book->title}}</a></td>
                                        <td><a href="{{route('admin.transactions.edit',$transaction->id)}}">{{$transaction->unitamount}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No transactions have been added yet</td></tr>
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