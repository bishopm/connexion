@extends('connexion::templates.webpage')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('content')
<div class="container">
	<div class="row">
		@if ((Auth::check()) and (isset($individual)))
			<h3>My planned giving</h3>
	        <div class="col-md-12">
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-md-6"><h4>Payments received from PG{{$individual->giving}}</h4></div>
	                    </div>
	                </div>
	                <div class="panel-body">
	                    <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
	                        <thead>
	                            <tr>
	                                <th>Date</th><th>Amount</th>
	                            </tr>
	                        </thead>
	                        <tfoot>
	                            <tr>
	                                <th>Date</th><th>Amount</th>
	                            </tr>
	                        </tfoot>
	                        <tbody>
	                            @forelse ($payments as $payment)
	                                <tr>
	                                    <td>{{$payment->paymentdate}}</td>
	                                    <td>{{$payment->amount}}</a></td>
	                                </tr>
	                            @empty
	                                <tr><td>No payments have been recorded yet</td></tr>
	                            @endforelse
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
		@else
        	<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to see your giving details</p>
        @endif
	</div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script language="javascript">
$(document).ready(function() {
    $('#indexTable').DataTable();
} );
</script>
@endsection