@extends('connexion::templates.frontend')

@section('title','Course details: ' . $course->title)

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
  <link href="{{ asset('/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')  
    <div class="container">
      <h3>{{$course->title}}
      @if (count($course->group))
        <small><a class="btn btn-xs btn-primary" href="{{url('/')}}/course/{{$course->slug}}/sign-up">Click here to sign up</a></small>
      @endif
      </h3>
        <div class="row">
          <div class="col-md-3"><img class="img-responsive" width="250px" src="{{url('/')}}/storage/courses/{{$course->image}}"></div>
          <div class="col-md-9">
          {!!$course->description!!}
          </div>
          <div class="col-md-9">
              @include('connexion::shared.comments', ['rating' => true])
          </div> 
          <hr>
        </div>
      </div>
    </div>
@stop

@section('js')
@if (Auth::check())
  <script src="{{url('/')}}/vendor/bishopm/rater/rater.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $( document ).ready(function() {
      var options = {
        max_value: 5,
        step_size: 1,
        initial_value: 0,
        selected_symbol_type: 'utf8_star', // Must be a key from symbols
        cursor: 'default',
        readonly: false,
        change_once: false, // Determines if the rating can only be set once
      }
      var optionsro = {
        max_value: 5,
        step_size: 1,
        selected_symbol_type: 'utf8_star', // Must be a key from symbols
        cursor: 'default',
        readonly: true,
      }
      $(".rating").rate(options);    
      $(".ratingro").rate(optionsro);    
    });
  </script>
@endif
@include('connexion::shared.ratercommentsjs', ['url' => route('admin.courses.addcomment',$course->id)])
@stop