@component('mail::message')
# {{$data['subject']}}

Hi {{$data['recipient']}} here is the bookshop report for last month:

# Sales

@foreach ($data['sales'] as $name=>$supplier)
### {{$name}}
@if (count($supplier))
@component('mail::table')
| Book | Cost price | Sale price | Units sold |
| -----|-----------:| ----------:|-----------:|
@foreach ($supplier as $sale)
|{{$sale->book->title}}|{{$sale->book->costprice}}|{{$sale->book->saleprice}}|{{$sale->units}}|
@endforeach
@endcomponent
Cost of Sales: R  {{number_format($data['costofsalestotal'][$name],2)}}
@else
No sales recorded this month
@endif
@endforeach

# New stock
@foreach ($data['deliveries'] as $name2=>$supplier2)
### {{$name2}}
@if (count($supplier2))
@component('mail::table')
| Book | Cost price |
| -----|-----------:|
@foreach ($supplier2 as $delivery)
|{{$delivery->book->title}}|{{$delivery->book->costprice}}|
@endforeach
@endcomponent
@else
No stock delivered during this period.
@endif
@endforeach

# Existing stock
@foreach ($data['stock'] as $name3=>$supplier3)
### {{$name3}}
@if (count($supplier3))
@component('mail::table')
| Book | Cost price | Units |
| -----|-----------:|------:|
@foreach ($supplier3 as $book)
|{{$book->title}}|{{$book->costprice}}|{{$book->stock}}|
@endforeach
@endcomponent
Cost of Stock: R  {{number_format($data['stockvalue'][$name3],2)}}
@else
No stock held at present.
@endif
@endforeach

Thank you :)
@endcomponent