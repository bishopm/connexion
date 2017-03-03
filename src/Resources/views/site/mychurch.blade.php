@extends('connexion::templates.webpage')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9">
	  	<h1>Meet the {{$setting['site_abbreviation']}} community</h1>
	  	<table id="mychurch">
	  		<thead>
                <tr>
                    <th></th>
                    <th>Surname</th>
                    <th>First name</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Surname</th>
                    <th>First name</th>
                </tr>
            </tfoot>
	  	@foreach ($users as $user)
	  		<tr><td><img width="100px" src="{{$user->individual->getMedia('image')->first()->getUrl()}}"></td><td>{{$user->individual->surname}}</td><td>{{$user->individual->firstname}}</td></tr>
	  	@endforeach
	  	</table>
	  </div>
	  <div class="col-md-3">
	  <h3>Recent activity</h3>
	  </div>
	</div>
</div>
@endsection

@section('js')
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script language="javascript">
  $(document).ready(function() {
    $('#mychurch').DataTable();
  });
</script>
@stop