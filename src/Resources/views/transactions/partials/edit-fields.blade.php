{{ Form::bsText('transactiondate','Date','Date',$transaction->transactiondate) }}
<div class='form-group '>
  <label for="book_id">Book</label>
  <select class="selectize" id="book_id" name="book_id">
  	<option></option>
    @foreach ($books as $book)
        @if ($book->id==$transaction->book_id)
            <option selected value="{{$book->id}}">{{$book->title}}</option>
        @else
            <option value="{{$book->id}}">{{$book->title}}</option>
        @endif
    @endforeach
  </select>
</div>
{{ Form::bsSelect('transactiontype','Transaction type',array('Cash sale','Card sale','Credit sale','Add stock','Shrinkage'),$transaction->transactiontype) }}
{{ Form::bsText('units','Quantity','Quantity',$transaction->units) }}
{{ Form::bsText('unitamount','Unit price','Unit price',$transaction->unitamount) }}
{{ Form::bsText('details','Notes','Notes',$transaction->notes) }}