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
                            <div class="col-md-6"><a href="{{route('admin.transactions.create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add a new transaction</a> <a href="{{route('admin.transactions.summary')}}" style="margin-right:6px;" class="btn btn-primary pull-right"><i class="fa fa-line-chart"></i> View this month</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th><th>Book</th><th>Amount</th><th>Type</th><th>Notes</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th><th>Book</th><th>Amount</th><th>Type</th><th>Notes</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>{{$transaction->transactiondate}}</td>
                                        <td>{{$transaction->book->title}}</td>
                                        <td>{{$transaction->unitamount}}</td>
                                        <td>{{$transaction->transactiontype}}</td>
                                        <td>{{$transaction->details}}</td>
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