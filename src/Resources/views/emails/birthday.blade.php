@component('mail::message')
# {{$emaildata['subject']}}

Hi {{$emaildata['recipient']}}

{!!$emaildata['emailmessage']!!}

Thank you :)
@endcomponent