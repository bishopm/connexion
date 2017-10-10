<div class="form-group">
  <label for="name">Sermon title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text">
</div>
{{ Form::bsText('servicedate','Service date','Service date',date('Y-m-d',strtotime('last Sunday'))) }}
{!! Form::label('mp3','Link to mp3', array('class'=>'control-label')) !!}
<input type="text" id="mp3" onchange="neaten(event);" name="mp3" class="form-control">
{{ Form::bsText('readings','Readings','Readings') }}
<div class='form-group '>
  <label for="individual_id">Preacher</label>
  <select class="selectize" id="individual_id" name="individual_id">
    @foreach ($preachers as $preacher)
      <option value="{{$preacher->id}}">{{$preacher->firstname}} {{$preacher->surname}}</option>
    @endforeach
    <option value="0">Guest preacher</option>
  </select>
</div> 
<div class='form-group '>
  <label for="tags">Tags</label>
  <select name="tags[]" class="input-tags" multiple>
  @foreach ($tags as $tag)
    <option value="{{$tag->name}}">{{$tag->name}}</option>
  @endforeach
  </select>
</div>
{{ Form::bsHidden('series_id',$series_id) }}