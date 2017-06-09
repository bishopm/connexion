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
                            <div class="col-md-6">
                                <span class="pull-right">
                                    <a href="{{route('admin.payments.create')}}" class="btn btn-primary"><i class="fa fa-pencil"></i> Add a new payment</a>
                                    <a href="{{url('/')}}/admin/payments/monthtotals/{{date('Y')}}" class="btn btn-primary"><i class="fa fa-pencil"></i>Monthly totals</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th><th>PG number</th><th>Amount</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th><th>PG number</th><th>Amount</th><th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td><a href="{{route('admin.payments.edit',$payment->id)}}">{{$payment->paymentdate}}</a></td>
                                        <td><a href="{{route('admin.payments.edit',$payment->id)}}">{{$payment->pgnumber}}</a></td>
                                        <td><a href="{{route('admin.payments.edit',$payment->id)}}">{{$payment->amount}}</a></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.payments.edit', [$payment->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-action-entity="Group" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.payments.destroy', [$payment->id]) }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
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
    @include('connexion::shared.delete-modal')
@endsection

@section('js')
@parent
<script language="javascript">
@include('connexion::shared.delete-modal-script')
$(document).ready(function() {
        $('#indexTable').DataTable();
    } );
</script>
@endsection