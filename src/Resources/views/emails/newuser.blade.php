@component('mail::message')
# Thanks for signing up!

Congratulations {{$emaildata->firstname}}!

You have successfully signed up as a user of our site. Click on the button below to confirm your email address and you'll be ready to go :)

@component('mail::button', ['url' => '{{url('/')}}/users/{{$emaildata->slug}}/confirmemail'])
Confirm my email address
@endcomponent

Thanks,<br>
{{$emaildata->sender}}
@endcomponent