@extends('connexion::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9 top30">
	    {{$page->body}}
	  </div>
	  <div class="col-md-3 top30">
	    Sidebar content
	  </div>
	</div>
</div>
@endsection