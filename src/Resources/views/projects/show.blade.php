@extends('adminlte::page')

@section('css')
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
  {{ Form::pgHeader($project->addressee,'Projects',route('admin.projects.index')) }}
@stop

@section('content')  
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary"> 
          <div class="box-header">
            <div class="row">
              <div class="col-md-6"><h4>{{$project->description}}</h4></div>
              <div class="col-md-6"><a href="{{route('admin.projects.edit',$project->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit project</a>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                @foreach ($project->actions as $task)
                  {{$task}}
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{url('/')}}/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.input-projects').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 30,
              onItemAdd: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/projects/{{$project->id}}/addmember/" + value })
              },
              onItemRemove: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/projects/{{$project->id}}/removemember/" + value })
              }
            });
            google.maps.event.addDomListener(window, 'load', initialize(16));
        });
    </script>
@stop