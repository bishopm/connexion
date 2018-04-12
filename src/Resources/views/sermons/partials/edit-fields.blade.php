<div class="form-group">
  <label for="name">Sermon title</label>
  <input class="form-control" data-slug="source" placeholder="Title" name="title" id="title" type="text" value="{{$sermon->title}}">
</div>
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text" value="{{$sermon->slug}}">
</div>
{{ Form::bsText('servicedate','Service date','Service date',$sermon->servicedate) }}
{!! Form::label('mp3','Link to mp3', array('class'=>'control-label')) !!}
<input type="text" id="mp3" onchange="neaten(event);" name="mp3" class="form-control" value="{{$sermon->mp3}}">
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
    @if ($sermon->individual_id==0)
      <option selected value="0">Guest preacher</option>
    @else
      <option value="0">Guest preacher</option>
    @endif
  </select>
</div>
@can('admin-backend')
  {{ Form::bsSelect('status','Status',array('Draft','Published'),$sermon->status) }}
@else
  {{ Form::bsSelect('status','Status',array('Draft'),$sermon->status) }}
@endcan
<div class='form-group '>
  <label for="tags">Tags</label>
  <select name="tags[]" class="input-tags" multiple>
  @foreach ($tags as $tag)
    @if ((count($btags)) and (in_array($tag->name,$btags)))
        <option selected value="{{$tag->name}}">{{$tag->name}}</option>
    @else
        <option value="{{$tag->name}}">{{$tag->name}}</option>
    @endif
  @endforeach
  </select>
</div>
@can('admin-backend')
  <div class='form-group '>
    <label for="series_id">Series</label>
    <select name="series_id" class="input-tags">
    @foreach ($allseries as $thisseries)
      @if ($thisseries->id == $series)
          <option selected value="{{$thisseries->id}}">{{$thisseries->title}} ({{date("M Y",strtotime($thisseries->created_at))}})</option>
      @else
          <option value="{{$thisseries->id}}">{{$thisseries->title}} ({{date("M Y",strtotime($thisseries->created_at))}})</option>
      @endif
    @endforeach
    </select>
  </div>
@else
  {{ Form::bsHidden('series_id',$series) }}
@endcan