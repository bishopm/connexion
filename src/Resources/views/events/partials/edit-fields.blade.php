{{ Form::bsText('groupname','Event name','Event name',$event->groupname) }}
<div class="form-group">
  <label for="slug">Slug</label>
  <input class="form-control" data-slug="target" placeholder="Slug" name="slug" id="slug" type="text" value="{{$event->slug}}">
</div>
{{ Form::bsTextarea('description','Brief description','Brief description',$event->description) }}
<div class='form-group '>
  <label for="individual_id">Leader</label>
  <select class="selectize" id="leader" name="leader">
      @foreach ($indivs as $indiv)
        @if ($indiv->id==$event->leader)
          <option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
        @else
          <option value="{{$indiv->id}}">{{$indiv->surname}}, {{$indiv->firstname}}</option>
        @endif
      @endforeach
    </select>
</div>
<div class="form-group">
  <label for="society_id">Date and time</label>
    <div class='input-group date' id='eventdatetime'>
        <input type='text' class="form-control" name="eventdatetime" value="{{date("Y-m-d H:i",$event->eventdatetime)}}"/>
        <span class="input-group-addon">
          <span class="fa fa-calendar"></span>
        </span>
    </div>
</div>
{{ Form::hidden('grouptype','event') }}
<div class="form-group">
  <label for="publish" class="control-label">Publish to website</label>
    @if ($event->publish)
      <input type="checkbox" name="publish" value="1" checked>
    @else
      <input type="checkbox" name="publish" value="1">
    @endif
</div>