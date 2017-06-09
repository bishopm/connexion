@component('mail::message')
# {{$emaildata->subject}}

{!!$emaildata->emailmessage!!}
@endcomponent