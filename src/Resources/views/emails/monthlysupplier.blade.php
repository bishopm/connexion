@component('mail::message')
# {{$data['subject']}}

To: {{$data['supplier']}}

# Sales
@component('mail::table')

@if (count ($data['sales']))
| Book | Cost price | Sale price | Units sold |
| -----|-----------:| ----------:| ----------:|
@foreach ($data['sales'] as $sale)
|{{$sale['book']->title}}|{{$sale['book']->costprice}}|{{$sale['book']->saleprice}}|{{$sale['units']}}|
@endforeach
Total Cost of Sales: R  {{number_format($data['costofsalestotal'],2)}}
Sales Total: R  {{number_format($data['salestotal'],2)}}
@else
No sales recorded during this period.
@endif

@endcomponent

# New stock
@component('mail::table')

@if (count ($data['deliveries']))
| Book | Units | Cost price | Sale price |
| -----| ------|-----------:|-----------:|
@foreach ($data['deliveries'] as $delivery)
|{{$delivery['book']->title}}|{{$delivery['units']}}|{{$delivery['book']->costprice}}|{{$delivery['book']->saleprice}}|
@endforeach

@else
No stock delivered during this period.
@endif

@endcomponent

# Existing stock
@component('mail::table')

@if (count ($data['stock']))
| Book | Cost price | Sale price | Units |
| -----|-----------:|-----------:|------:|
@foreach ($data['stock'] as $book)
|{{$book->title}}|{{$book->costprice}}|{{$book->saleprice}}|{{$book->stock}}|
@endforeach
Total Cost of Stock: R  {{number_format($data['stockvalue'],2)}}
@else
No stock held at present.
@endif

@endcomponent

# Shrinkage
@component('mail::table')

@if (count ($data['shrinkage']))
| Book | Cost price | Sale price | Units missing |
| -----|-----------:| ----------:| ----------:|
@foreach ($data['shrinkage'] as $shrinkage)
|{{$shrinkage['book']->title}}|{{$shrinkage['book']->costprice}}|{{$shrinkage['book']->saleprice}}|{{$shrinkage['units']}}|
@endforeach
Total Cost of Missing books: R  {{number_format($data['shrinkagetotal'],2)}}
@else
No shrinkage recorded during this period.
@endif

@endcomponent

Thank you :)
@endcomponent