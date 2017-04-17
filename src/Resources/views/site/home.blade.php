@extends('connexion::templates.webpage')

@section('css')
<link href="{{ asset('/vendor/bishopm/mediaelement/build/mediaelementplayer.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@include('connexion::shared.errors')
@include('connexion::shared.carousel')
<div class="container top30">
  <!-- Three columns of text below the carousel -->
  <div class="row">
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/blog.png')}}">
      <h4>From our Blog</h4>
      <div class="top30 list-unstyled text-left">
        @if (count($blogs))
          @foreach ($blogs as $blog)
            @if ($loop->first)
              <div class="col-xs-12">
                <div class="highlight">
                  <a id="highlightlink" href="{{url('/')}}/blog/{{$blog->slug}}">
                  @if (count($blog->getMedia('image')))
                    <img height="80px" style="float:right;margin-left:7px;" src="{{$blog->getMedia('image')->first()->getUrl()}}">
                  @endif
                  {{$blog->title}}</a><a href="{{url('/')}}/blog/{{$blog->slug}}">
                  @if (strlen($blog->body > 199))
                    {!!substr($blog->body, 0, strpos($blog->body, ' ', 200))!!}
                  @else
                    {!!substr($blog->body, 0, strrpos($blog->body, ' '))!!}
                  @endif
                  </a>
                </div>
              </div>
            @else
              <div class="col-xs-12 top5">{{date("j M", strtotime($blog->created_at))}}&nbsp;<a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></div>
            @endif
          @endforeach
        @else
          <li>No blog posts have been published yet</li>
        @endif
      </div>      
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/preaching.png')}}">
      <h4>Last Sunday</h4>
      @if ($sermon)
        @if (null!==$sermon->series->getMedia('image')->first())
          <a href="{{route('webseries',$sermon->series->slug)}}"><img class="top17" src="{{$sermon->series->getMedia('image')->first()->getUrl()}}"></a>
        @endif
        <audio class="center-block" controls="" width="250px" preload="none" height="30px" src="{{$sermon->mp3}}"></audio>
        <div class="col-md-12">{{date("j M", strtotime($sermon->servicedate))}}: <a href="{{route('websermon',array($sermon->series->slug,$sermon->slug))}}">{{$sermon->title}}</a></div>
        <div class="col-md-12"><a href="{{url('/')}}/people/{{$sermon->individual->slug}}">{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</a></div>
      @else
        No sermons have been added yet
      @endif
    </div>
    <div class="col-md-4 text-center">
      @if (Auth::check())
        <img src="{{asset('vendor/bishopm/images/community.png')}}">
        <h4>What are we saying?</h4>
        <ul class="list-unstyled top20"><small>
          @foreach ($comments as $comment)
            <li class="text-left">
              <a href="{{url('/')}}/users/{{$comment->commented->individual->slug}}">{{$comment->commented->individual->firstname}} {{$comment->commented->individual->surname}}</a> commented on 
              @if ($comment->commentable_type=="Bishopm\Connexion\Models\Blog")
                <a href="{{url('/')}}/blog/{{$comment->commentable->slug}}">
              @elseif ($comment->commentable_type=="Bishopm\Connexion\Models\Sermon")
                <a href="{{url('/')}}/sermons/{{$comment->commentable->series->slug}}/{{$comment->commentable->slug}}">
              @elseif ($comment->commentable_type=="Bishopm\Connexion\Models\Course")
                <a href="{{url('/')}}/course/{{$comment->commentable->slug}}">
              @elseif ($comment->commentable_type=="Bishopm\Connexion\Models\Book")
                <a href="{{url('/')}}/book/{{$comment->commentable->slug}}">                
              @endif
              {{substr($comment->commentable->title,0,20)}}
              @if (strlen($comment->commentable->title)>20)
                ...
              @endif
              </a>
            </li>
          @endforeach
        </small></ul>
        <h4 class="top30">Welcome to our newest users!</h4>
        <p class="text-left"><small>
        @forelse ($users as $user)
            @if ($user->individual)
              <a href="{{url('/')}}/users/{{$user->individual->slug}}">{{$user->individual->firstname}} {{$user->individual->surname}}</a>
              @if (!$loop->last)
                ,
              @endif
            @endif
        @empty
            No users are set up yet
        @endforelse
        </small></p>
      @else
        <img src="{{asset('vendor/bishopm/images/contact.png')}}">
        <h4>Find us</h4>
        <ul class="list-unstyled top17">
            <li><b>Sunday services:</b> 07h00 | 08h30 | 1000</li>
            <li><b>Children and youth:</b> Sundays 08h30</li>
        </ul>      
        <img class="img-responsive" src="{{ asset('vendor/bishopm/images/map.png') }}">
        <ul class="list-unstyled top10">
          <li><i class="fa fa-phone"></i>  <b>032 947 0173</b></li>
          <li><a href="{{url('/')}}/contact">Interactive map and full contact details</a></li>
        </ul>
      @endif
    </div>
  </div><!-- /.row -->
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/bishopm/mediaelement/build/mediaelement.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bishopm/mediaelement/build/mediaelementplayer.js') }}" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {
  jQuery(window).on('load', function() {
    $('.carousel').carousel({
      pause: "false",
      interval: 4000
    });
    $('audio').mediaelementplayer({
      features: ['playpause','tracks','progress','volume'],
    });
  });
})(jQuery);
</script>
@endsection