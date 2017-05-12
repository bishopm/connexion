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
                            <div class="col-md-6"><h4>Payments</h4></div>
                            <div class="col-md-6"><a href="{{route('admin.payments.create')}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add a new payment</a></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th><th>PG number</th><th>Amount</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th><th>PG number</th><th>Amount</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td><a href="{{route('admin.payments.edit',$payment->id)}}">{{$payment->paymentdate}}</a></td>
                                        <td><a href="{{route('admin.payments.edit',$payment->id)}}">{{$payment->pgnumber}}</a></td>
                                        <td><a href="{{route('admin.payments.edit',$payment->id)}}">{{$payment->amount}}</a></td>
                                    </tr>
                                @empty
                                    <tr><td>No payments have been added yet</td></tr>
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