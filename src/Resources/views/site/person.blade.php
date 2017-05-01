@extends('connexion::templates.webpage')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
@stop

@section('content')
<div class="container">
	<div class="row top30">
	  <div class="col-md-4">
	    @if (isset($person->user->individual->image))
            <img class="img-responsive img-circle img-thumbnail" src="{{url('/')}}/storage/individuals/{{$person->user->individual->id}}/{{$person->user->individual->image}}">
        @else
            <img class="img-responsive img-circle img-thumbnail" src="{{asset('vendor/bishopm/images/profile.png')}}">
        @endif
	  </div>
	  <div class="col-md-4">
	    <h3>{{$person->firstname}} {{$person->surname}}</h3>
	    {{$person->user->bio or ''}}
	  </div>
	  <div class="col-md-4">
	  	<h3>Get in touch</h3>
	  	@if ($staff)
		  	{{$person->firstname}} is a staff member at {{$setting['site_abbreviation']}}.<br> Send {{$person->firstname}} an {{ HTML::mailto($person->email,'email') }}
		@endif

	  	@if ($person->user)
	  		<a href="{{url('/')}}/users/{{$person->slug}}" class="top17 btn btn-primary">View {{$person->firstname}}'s user page</a>
	  	@endif
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
		                    	<td>{{date("Y-m-d",strtotime($sermon->servicedate))}}</td>
		                        <td><a href="{{url('/')}}/sermons/{{$sermon->series->slug}}/{{$sermon->slug}}">{{$sermon->title}}</a></td>
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
		                    	<td>{{date("Y-m-d",strtotime($blog->created_at))}}</td>
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
    $('#sermonTable').DataTable( {
            "order": [[ 0, "desc" ]]
        } );
    $('#blogTable').DataTable( {
            "order": [[ 0, "desc" ]]
        } );
  });
</script>
@stop