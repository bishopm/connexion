Thanks for signing up as a user on our site, {{$user->individual->firstname}}

Click on the button below to confirm your email address and you'll be ready to go :)

<a class="btn btn-primary" href="{{route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">Confirm my email address</a>

Thanks!

{{$setting['site_name']}}