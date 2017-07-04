@component('mail::message')
# {{$data['subject']}}

Dear Planned Giver **{{$data['pg']}}**

Thank you so much for making ministry possible at {{$data['church']}} by participating in our Planned Giving programme.

Please find below for your records a breakdown of your planned giving for the last {{$data['scope']}}. This mail is to help you to track your giving and ensure that our record-keeping is accurate. 

This email is system-generated to preserve anonymity.

Please feel free to contact the church office if you have any questions or concerns.

# Last {{$data['scope']}}
@if (isset($data['current']))
@component('mail::table')
| Date received | Amount | 
| -----|-----------:| 
@foreach ($data['current'] as $payment)
|{{$payment->paymentdate}}|{{number_format($payment->amount,2)}}|
@endforeach
@endcomponent
@else
No payments received during this period
@endif

@if (isset($data['historic']))
# Other {{$data['pgyr']}} payments (prior to the last {{$data['scope']}})

@component('mail::table')
| Date received | Amount | 
| -----|-----------:| 
@foreach ($data['historic'] as $payment)
|{{$payment->paymentdate}}|{{number_format($payment->amount,2)}}|
@endforeach
@endcomponent
@endif

May God bless and encourage you as you continue to serve Him.

Thank you!
@endcomponent