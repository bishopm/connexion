@extends('connexion::templates.frontend')

@section('title','Home page')

@section('css')
<link href="{{ asset('/vendor/bishopm/mediaelement/build/mediaelementplayer.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container top30">
  <!-- Three columns of text below the carousel -->
  <div class="row">
    <div class="col-md-4 text-center" style="z-index: 1;">
      <img src="{{asset('/vendor/bishopm/themes/' . $setting['website_theme'] . '/images/blog.png')}}">
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
                    <div class="text-justify">{!!substr($blog->body, 0, strpos($blog->body, ' ', 400))!!}</div>
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
            <span class="pull-right"><a href="{{url('/')}}/blog">more posts...</a></span>
          </div>
        @else
          No blog posts have been published yet
        @endif
        @if (count($events))
          <div class="text-center">
            <img src="{{asset('/vendor/bishopm/themes/' . $setting['website_theme'] . '/images/diary.png')}}">
            <h4>Coming up</h4>
            <ul class="list-unstyled" style="margin-bottom:20px;">
            @foreach ($events as $event)
              <li>{{date('j F',$event->eventdatetime)}} <a href="{{url('/')}}/coming-up/{{$event->slug}}">{{$event->groupname}} ({{$event->individuals->count()}} attending)</a></li>
            @endforeach
            </ul>
          </div>
        @endif
      </div>      
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('/vendor/bishopm/themes/' . $setting['website_theme'] . '/images/preaching.png')}}">
      <h4>Last Sunday</h4>
      @if ($sermon)
        @if ($sermon->series->image)
          <a href="{{route('webseries',$sermon->series->slug)}}"><img class="top17" src="{{url('/')}}/storage/series/{{$sermon->series->image}}"></a>
        @endif
        <audio class="mx-auto" controls="" width="250px" preload="none" height="30px" src="{{$sermon->mp3}}"></audio>
        <div class="col-md-12">{{date("j M", strtotime($sermon->servicedate))}}: <a href="{{route('websermon',array($sermon->series->slug,$sermon->slug))}}">{{$sermon->title}}</a></div>
        <div class="col-md-12">
          @if ($sermon->individual)
            <a href="{{url('/')}}/people/{{$sermon->individual->slug}}">{{$sermon->individual->firstname}} {{$sermon->individual->surname}}</a>
          @else
            Guest preacher
          @endif
        </div>
        <div style="margin-bottom:20px;" class="center-text"><a class="btn btn-xs btn-primary" href="{{url('/')}}/sermons">Browse full sermon library</a></div>
      @else
        <div class="top30">
          No sermons have been added yet  
        </div>
      @endif
    </div>
    <div class="col-md-4 text-center">
      @if ((Auth::check()) and (Auth::user()->verified==1))
        <img src="{{asset('/vendor/bishopm/themes/' . $setting['website_theme'] . '/images/community.png')}}">
        <h4>What are we saying?</h4>
        <ul class="list-unstyled top30">
          @forelse ($comments as $comment)
            <li class="text-left"><small>
              @if (isset($comment->commentable_type))
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
              @else
                <a href="{{url('/')}}/users/{{$comment->user->individual->slug}}">{{$comment->user->individual->firstname}} {{$comment->user->individual->surname}}</a> 
                @if ($comment->title)
                  posted <a href="{{url('/')}}/forum/posts/{{$comment->id}}">{{$comment->title}}</a>
                @else
                  replied to <a href="{{url('/')}}/forum/posts/{{$comment->thread}}">{{$comment->threadtitle($comment->thread)->title}}</a>
                @endif
              @endif
            </small></li>
          @empty
            No users have posted comments yet
          @endforelse
        </ul>
        @if (isset(Auth::user()->individual))
          <h4 class="top30">Welcome to our 10 newest users!<br><small>{{$usercount}} users registered so far | <a href="{{url('/my-church')}}">View gallery</a></small></h4>
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
        <img src="{{asset('/vendor/bishopm/themes/' . $setting['website_theme'] . '/images/contact.png')}}">
        <h4>Find us</h4>
        <ul class="list-unstyled top17">
            <li><b>Sunday services:</b> 07h00 | 08h30 | 1000</li>
            <li><b>Children and youth:</b> Sundays 08h30</li>
        </ul>
        <p style="text-align:center;">
          @if ($setting['home_latitude'])
            <a href="{{url('/contact')}}">
            <img style="width:100%; height:200px;" src="https://maps.googleapis.com/maps/api/staticmap?center={{$setting['home_latitude']}},{{$setting['home_longitude']}}&zoom=15&size=400x200&maptype=roadmap&markers=icon:http://maps.google.com/mapfiles/kml/pal2/icon11.png%7Ccolor:red%7C{{$setting['home_latitude']}},{{$setting['home_longitude']}}&key={{$setting['google_api']}}">
            </a>
          @else
            To include a Google Map, please add church co-ordinates in back-end
          @endif
        </p>
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
<script src="{{ asset('/vendor/bishopm/mediaelement/build/mediaelement.js') }}" type="text/javascript"></script>
<script src="{{ asset('/vendor/bishopm/mediaelement/build/mediaelementplayer.js') }}" type="text/javascript"></script>
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