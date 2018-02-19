@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{$emaildata->header}}
@endcomponent
@endslot
# {{$emaildata->subject}}

{!! $emaildata->emailmessage !!}

@slot('footer')
@component('mail::footer')
<i>{{$emaildata->footer}}</i><br>
{{$emaildata->address}}<br><br>
@if ($emaildata->facebook)
    <a title="Like us on Facebook" target="_blank" href="{{$emaildata->facebook}}"><img alt="Like us on Facebook" style="margin-right:5px; margin-left:5px" width="25px" src="{{asset('/vendor/bishopm/images/facebook.png')}}"></a>
@endif
@if ($emaildata->twitter)
    <a title="Follow us on Twitter" target="_blank" href="{{$emaildata->twitter}}"><img alt="Follow us on Twitter" style="margin-right:5px; margin-left:5px" width="25px" src="{{asset('/vendor/bishopm/images/twitter.png')}}"></a>
@endif
@if ($emaildata->youtube)
    <a title="Youtube profile page" target="_blank" href="{{$emaildata->youtube}}"><img alt="Youtube profile page" style="margin-right:5px; margin-left:5px" width="25px" src="{{asset('/vendor/bishopm/images/youtube.png')}}"></a>
@endif
@endcomponent
@endslot
@endcomponent