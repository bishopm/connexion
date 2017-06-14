@component('mail::message')
# {{$data['subject']}}

Hi {{$data['recipient']}}

# Sales
@component('mail::table')

@if (count ($data['sales']))
| Book | Cost price | Units sold |
| -----|-----------:| ----------:|
@foreach ($data['sales'] as $name=>$supplier)
### {{$name}}
@foreach ($supplier as $sale)
|{{$sale->book->title}}|{{$sale->book->costprice}}|{{$sale->units}}|
@endforeach
@endforeach
Total Cost of Sales: R  {{number_format($data['costofsalestotal'],2)}}
@else
No sales recorded during this period.
@endif

@endcomponent

# New stock
@component('mail::table')

@if (count ($data['deliveries']))
| Book | Cost price |
| -----|-----------:|
@foreach ($data['deliveries'] as $delivery)
|{{$delivery->book->title}}|{{$delivery->book->costprice}}|
@endforeach

@else
No stock delivered during this period.
@endif

@endcomponent

# Existing stock
@component('mail::table')

@if (count ($data['stock']))
| Book | Cost price | Units |
| -----|-----------:|------:|
@foreach ($data['stock'] as $book)
|{{$book->title}}|{{$book->costprice}}|{{$book->stock}}|
@endforeach
Total Cost of Stock: R  {{number_format($data['stockvalue'],2)}}
@else
No stock held at present.
@endif

@endcomponent



Thank you :)
@endcomponent