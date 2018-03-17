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
                    <div id="highlighted" class="text-justify">{!!substr(str_replace('</p>',' ',str_replace('<p>','',$blog->body)), 0, strpos($blog->body, ' ', 500))!!}</div>
                    </a>
                </div>
                </div>
            @else
                @if ($loop->index==1)
                    <div class="col-xs-12 mt-2" style="padding-left:26px;">
                @else
                    <div class="col-xs-12" style="padding-left:26px;">
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