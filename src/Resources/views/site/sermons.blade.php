@extends('connexion::templates.webpage')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-12">
		  <h3>{{$setting['site_abbreviation']}} preaching series</h3>  
	  	  <table id="seriesTable" class="table table-responsive table-striped">
	  	  	  <thead>
	  	  	  	<tr><th>Series title</th><th>Starting date</th><th>No. of sermons</th></tr>
	  	  	  </thead>
	  	  	  <tbody>
			      @foreach ($series as $serie)
			      	  <tr><td><a href="{{url('/')}}/sermons/{{$serie->slug}}">{{$serie->series}}</a></td><td>{{date("d M Y",strtotime($serie->created_at))}}</td><td>{{count($serie->sermons)}}</td></tr>
			      @endforeach
			  </tbody>
		  </table>
	  </div>
	</div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script language="javascript">
  $(document).ready(function() {
    $('#seriesTable').DataTable();
  });
</script>
@stop