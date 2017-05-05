@extends('connexion::templates.webpage')

@section('css')
<link href="{{ asset('/public/vendor/bishopm/mediaelement/build/mediaelementplayer.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container top30">
  <!-- Three columns of text below the carousel -->
  <div class="row">
    <div class="col-md-4 text-center" style="z-index: 1;">
      <img src="{{asset('public/vendor/bishopm/images/blog.png')}}">
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
                  <div class="small"><b>{{date("d M Y",strtotime($blog->created_at))}}</b> {{$blog->individual->firstname}} {{$blog->individual->surname}}</div>
                  @if (strlen($blog->body > 199))
                    {!!substr($blog->body, 0, strpos($blog->body, ' ', 200))!!}
                  @else
                    {!!substr($blog->body, 0, strrpos($blog->body, ' '))!!}
                  @endif
                  </a>
                </div>
              </div>
            @else
              @if ($loop->index==1)
                <div class="col-xs-12 top10" style="padding-left:26px;">
              @else
                <div class="col-xs-12 top5" style="padding-left:26px;">
              @endif
                {{date("d M", strtotime($blog->created_at))}}&nbsp;<a href="{{url('/')}}/blog/{{$blog->slug}}">{{$blog->title}}</a></div>
            @endif
          @endforeach
          <div class="col-xs-12 top10">
            <span class="pull-right"><a href="{{url('/')}}/blog">more...</a></span>
          </div>
        @else
          No blog posts have been published yet
        @endif
      </div>      
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('public/vendor/bishopm/images/preaching.png')}}">
      <h4>Last Sunday</h4>
      @if ($sermon)
        @if ($sermon->series->image)
          <a href="{{route('webseries',$sermon->series->slug)}}"><img class="top17" src="{{url('/')}}/public/storage/series/{{$sermon->series->image}}"></a>
        @endif
        <audio class="center-block" controls="" width="250px" preload="none" height="30px" src="{{$sermon->mp3}}"></audio>
        <div class="col-md-12">{{date("j M", strtotime($sermon->servicedate))}}: <a href="{{route('websermon',array($sermon->series->slug,$sermon->slug))}}">{{$sermon->title}}</a></div>
        <div class="col-md-12"><a href="{{url('/')}}/people/{{$sermon->individual->slug}}">{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</a></div>
      @else
        <div class="top30">
          No sermons have been added yet  
        </div>
      @endif
    </div>
    <div class="col-md-4 text-center">
      @if ((Auth::check()) and (Auth::user()->verified==1))
        <img src="{{asset('public/vendor/bishopm/images/community.png')}}">
        <h4>What are we saying?</h4>
        <ul class="list-unstyled top30">
          @forelse ($comments as $comment)
            <li class="text-left"><small>
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
            </small></li>
          @empty
            No users have posted comments yet
          @endforelse
        </ul>
        @if (isset(Auth::user()->individual))
          <h4 class="top30">Welcome to our 10 newest users!</h4>
          <p class="text-left"><small>
          @forelse ($users as $user)
            @if (!$loop->last)
              <a href="{{url('/')}}/users/{{$user->individual->slug}}">{{$user->individual->firstname}} {{$user->individual->surname}}</a>, 
            @else
              <a href="{{url('/')}}/users/{{$user->individual->slug}}">{{$user->individual->firstname}} {{$user->individual->surname}}</a>. 
            @endif            
          @empty
              No users are set up yet
          @endforelse
          </small></p>
        @endif
      @else
        <img src="{{asset('public/vendor/bishopm/images/contact.png')}}">
        <h4>Find us</h4>
        <ul class="list-unstyled top17">
            <li><b>Sunday services:</b> 07h00 | 08h30 | 1000</li>
            <li><b>Children and youth:</b> Sundays 08h30</li>
        </ul>      
        <img class="img-responsive" src="{{ asset('public/vendor/bishopm/images/map.png') }}">
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
<script src="{{ asset('public/vendor/bishopm/mediaelement/build/mediaelement.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/vendor/bishopm/mediaelement/build/mediaelementplayer.js') }}" type="text/javascript"></script>
@endsection