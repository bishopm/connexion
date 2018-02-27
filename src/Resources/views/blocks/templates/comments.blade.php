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