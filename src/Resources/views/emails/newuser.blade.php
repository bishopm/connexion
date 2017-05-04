@component('mail::message')
# Welcome!

Thanks for signing up as a user on our site, {{$user->individual->firstname}}<br><br>

Click on the button below to confirm your email address and you'll be ready to go :) 

Once you are logged in, take a moment to explore the user menu in the top right hand corner of the site. Go and visit your user profile page, where you can upload a pic (and include a short bio if you like). The My {{$setting['site_abbreviation']}} link below that introduces you to other church member who are users on the system. 

You can also update your (and your family's) contact details through this menu.

@component('mail::button', ['url' => route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email)])
Confirm my email address
@endcomponent

Enjoy exploring the site - let us know if you have any feedback or run into any trouble!<br>

{{$setting['site_name']}}
@endcomponent