@extends('base::templates.webpage')

@section('htmlheader_title')
    Dashboard
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    {{$page->body}}
  </div>
  <div class="col-md-4">
    Sidebar content
  </div>
</div>
@endsection