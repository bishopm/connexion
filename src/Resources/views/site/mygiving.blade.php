@extends('connexion::templates.frontend')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
@stop

@section('content')
<div class="container">
	<div class="row">
		@if ((Auth::check()) and (isset($individual)))
			<h3>My planned giving</h3>
	        <div class="col-md-12">
	            <div class="card card-default">
	            	@if ($individual->giving)
		                <div class="card-heading">
		                    <div class="row">
		                        <div class="col-md-6"><h4>Payments received from PG{{$individual->giving}}</h4></div>
		                    </div>
		                </div>
		                <div class="card-body w-100">
		                    <table id="indexTable" class="table table-striped table-hover table-condensed table-responsive" cellspacing="0">
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
		            @else
		            	<div class="alert alert-primary">Sorry, you have not yet been assigned a Planned Giving number. From the User menu, choose edit my details and you will be able to pick a PG number. Or give us a ring at the office for help.</div>
		            @endif
	            </div>
	        </div>
		@else
        	<p class="top20"><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to see your giving details</p>
        @endif
	</div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script language="javascript">
$(document).ready(function() {
    $('#indexTable').DataTable();
} );
</script>
@endsection