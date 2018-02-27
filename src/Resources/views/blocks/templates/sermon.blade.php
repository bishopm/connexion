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
    <div style="margin-bottom:20px;" class="center-text">
        <a class="btn btn-xs btn-primary" href="{{url('/')}}/sermons">
            Browse full sermon library  
        </a>
    </div>
@else
    <div class="top30">
        No sermons have been added yet  
    </div>
@endif