@extends('connexion::templates.webpage')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row top30">
	  <div class="col-md-3">
	    <img src="{{$person->getMedia('image')->first()->getUrl()}}" class="img-circle img-thumbnail">
	  </div>
	  <div class="col-md-9">
	    <h3>{{$person->firstname}} {{$person->surname}}</h3>
	    Bio: {{$person->user->bio}}
	  </div>
	</div>
  	<div class="row">
  		@if (count($person->sermons))
	    	<div class="col-md-6">
	    		<h4 class="text-center">Sermons</h4>
		    	<table id="sermonTable" class="table table-striped table-hover table-condensed table-responsive" width="100%" cellspacing="0">
		            <thead>
		                <tr>
		                	<th>Date</th>
		                    <th>Sermon</th>
		                    <th>Readings</th>
		                </tr>
		            </thead>
		            <tfoot>
		                <tr>
		                	<th>Date</th>
		                    <th>Sermon</th>
		                    <th>Readings</th>
		                </tr>
		            </tfoot>
		            <tbody>
		                @forelse ($person->sermons as $sermon)
		                    <tr>
		                    	<td>{{date("d M Y",strtotime($sermon->servicedate))}}</td>
		                        <td><a href="{{url('/')}}/sermons/{{$sermon->series->slug}}/{{$sermon->slug}}">{{$sermon->sermon}}</a></td>
		                        <td>{{$sermon->readings}}</td>
		                    </tr>
		                @empty
		                    <tr><td>No sermons have been added yet</td></tr>
		                @endforelse
		            </tbody>
		        </table>
	    	</div>
	    @endif
	    @if (count($person->blogs))
		    <div class="col-md-6">
		    	<h4 class="text-center">Blogs</h4>
		    	<table id="blogTable" class="table table-responsive table-condensed" width="100%" cellspacing="0">
		            <thead>
		                <tr>
		                	<th>Date</th>
		                    <th>Blog title</th>
		                </tr>
		            </thead>
		            <tfoot>
		                <tr>
		                	<th>Date</th>
		                    <th>Blog title</th>
		                </tr>
		            </tfoot>
		            <tbody>
		                @forelse ($person->blogs as $blog)
		                    <tr>
		                    	<td>{{date("d M Y",strtotime($blog->created_at))}}</td>
		                        <td><a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></td>
		                    </tr>
		                @empty
		                    <tr><td>No blog posts have been added yet</td></tr>
		                @endforelse
		            </tbody>
		        </table>
		    </div>
		@endif
  	</div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script language="javascript">
  $(document).ready(function() {
    $('#sermonTable').DataTable();
    $('#blogTable').DataTable();
  });
</script>
@stop