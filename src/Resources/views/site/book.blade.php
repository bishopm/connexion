@extends('connexion::templates.webpage')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop

@section('content')  
    <div class="container">
      <h3>{{$book->title}}<small>
        @foreach ($book->tags as $tag)
          <a class="label label-primary" href="{{url('/')}}/subject/{{$tag->name}}">{{$tag->name}}</a></b>&nbsp;
        @endforeach
        </small></h3>
        <div class="row">
          <div class="col-md-3"><img class="img-responsive" width="250px" src="{{$book->getMedia('image')->first()->getUrl()}}"></div>
          <div class="col-md-9">
          {!!$book->description!!}
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
@include('connexion::shared.ratercommentsjs', ['url' => route('admin.books.addcomment',$book->id)])
@stop