{{ Form::bsText('sermon','Sermon title','Sermon title',$sermon->sermon) }}
{{ Form::bsText('slug','Slug','Slug',$sermon->slug) }}
{{ Form::bsText('servicedate','Service date','Service date',$sermon->servicedate) }}
{{ Form::bsText('mp3','Link to mp3','Link to mp3',$sermon->mp3) }}
{{ Form::bsText('readings','Readings','Readings',$sermon->readings) }}
<div class='form-group '>
  <label for="individual_id">Preacher</label>
  <select class="selectize" id="individual_id" name="individual_id">
    @foreach ($preachers as $preacher)
    	@if ($preacher->id==$sermon->individual_id)
	        <option selected value="{{$preacher->id}}">{{$preacher->firstname}} {{$preacher->surname}}</option>
	    @else
	    	<option value="{{$preacher->id}}">{{$preacher->firstname}} {{$preacher->surname}}</option>
	    @endif
    @endforeach
  </select>
</div> 
{{ Form::bsHidden('series_id',$series) }}