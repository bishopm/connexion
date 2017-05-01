{{ Form::bsText('transactiondate','Date','Date',date('Y-m-d')) }}
<div class='form-group '>
  <label for="book_id">Book</label>
  <select class="selectize" id="book_id" name="book_id">
  	<option></option>
    @foreach ($books as $book)
      <option value="{{$book->id}}">{{$book->title}}</option>
    @endforeach
  </select>
</div>
{{ Form::bsSelect('transactiontype','Transaction type',array('Cash sale','Card sale','Credit sale','Add stock','Shrinkage')) }}
{{ Form::bsText('units','Quantity','Quantity',1) }}
{{ Form::bsText('unitamount','Unit price','Unit price') }}
{{ Form::bsText('details','Notes','Notes') }}