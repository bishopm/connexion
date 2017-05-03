@component('mail::message')
# {{$emaildata->subject}}

{!!$emaildata->emailmessage!!}

Thanks,<br>
{{$emaildata->sender}}
@endcomponent