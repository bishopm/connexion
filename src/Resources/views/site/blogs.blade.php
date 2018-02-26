@extends('connexion::templates.frontend')

@section('title','Blog')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
@stop

@section('content')
<div class="container">
	<div class="row">
	  <div class="col-md-12">
		  <h3>{{$setting['site_abbreviation']}} blog</h3>  
	  	  <table id="seriesTable" class="table table-responsive table-striped">
	  	  	  <thead>
	  	  	  	<tr><th>Date</th><th>Title</th><th>Author</th><th>Comments</th></tr>
	  	  	  </thead>
	  	  	  <tbody>
			      @foreach ($blogs as $blog)
			      	  <tr><td><a href="{{url('/')}}/blog/{{$blog->slug}}">{{date("Y-m-d",strtotime($blog->created_at))}}</a></td><td><a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></td><td><a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->individual->firstname}} {{$blog->individual->surname}}</a></td><td><a href="{{url('/')}}/blog/{{$blog->slug}}">{{count($blog->comments)}}</a></td></tr>
			      @endforeach
			  </tbody>
		  </table>
	  </div>
	</div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script language="javascript">
  $(document).ready(function() {
    $('#seriesTable').DataTable( {
            "order": [[ 0, "desc" ]]
        } );
  });
</script>
@stop