@component('mail::message')
# Welcome!

Thanks for signing up as a user on our site, {{$user->individual->firstname}}<br><br>

Click on the button below to confirm your email address and you'll be ready to go :)

@component('mail::button', ['url' => route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email)])
Confirm my email address
@endcomponent

Enjoy exploring the site - let us know if you run into any trouble!<br>
{{$setting['site_name']}}
@endcomponent