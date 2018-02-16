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
{{$emaildata->footer}}
@endcomponent
@endslot
@endcomponent