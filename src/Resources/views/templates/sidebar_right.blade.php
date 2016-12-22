@extends('base::templates.webpage')

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="row">
  <div class="col-md-9">
    {{$page->body}}
  </div>
  <div class="col-md-3">
    Sidebar content
  </div>
</div>
@endsection