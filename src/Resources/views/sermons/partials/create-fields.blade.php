{{ Form::bsText('sermon','Sermon title','Sermon title') }}
{{ Form::bsText('slug','Slug','Slug') }}
{{ Form::bsText('servicedate','Service date','Service date') }}
{{ Form::bsText('mp3','Link to mp3','Link to mp3') }}
{{ Form::bsText('readings','Readings','Readings') }}
<div class='form-group '>
  <label for="individual_id">Preacher</label>
  <select class="selectize" id="individual_id" name="individual_id">
    @foreach ($preachers as $preacher)
      <option value="{{$preacher->id}}">{{$preacher->firstname}} {{$preacher->surname}}</option>
    @endforeach
  </select>
</div> 
{{ Form::bsHidden('series_id',$series_id) }}