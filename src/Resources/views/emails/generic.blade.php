@component('mail::message')
# {{$emaildata->subject}}

{{$emaildata->emailmessage}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{$emaildata->sender}}
@endcomponent