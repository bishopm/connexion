@extends('connexion::templates.webpage')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('content')
<div class="container">
	<div class="row">
	  <div class="col-md-12">
		  <h3>{{$setting['site_abbreviation']}} preaching series</h3>  
	  	  <table id="seriesTable" class="table table-responsive table-striped">
	  	  	  <thead>
	  	  	  	<tr><th>Starting date</th><th>Series title</th><th>No. of sermons</th><th></th></tr>
	  	  	  </thead>
	  	  	  <tbody>
			      @foreach ($series as $serie)
			      	  <tr><td><a href="{{url('/')}}/sermons/{{$serie->slug}}">{{date("Y-m-d",strtotime($serie->created_at))}}</a></td><td><a href="{{url('/')}}/sermons/{{$serie->slug}}">{{$serie->title}}</a></td><td><a href="{{url('/')}}/sermons/{{$serie->slug}}">{{count($serie->sermons)}}</a></td><td><a href="{{url('/')}}/sermons/{{$serie->slug}}"><img width="60px" src="{{url('/')}}/storage/series/{{$serie->image}}"></a></td></tr>
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
    $('#seriesTable').DataTable( {
            "order": [[ 0, "desc" ]]
        } );
  });
</script>
@stop