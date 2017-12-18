{{ Form::bsText('description','Description','Description',$action->description) }}
{{ Form::bsHidden('user_id',$action->user_id) }}
<div class='form-group '>
  <label for="folder_id">Status</label>
  <select id="folder_id" name="folder_id">
    <option></option>
    @foreach ($folders as $folder)
      @if ($folder->id==$action->folder_id)
        <option selected value="{{$folder->id}}">{{$folder->folder}}</option>
      @else
        <option value="{{$folder->id}}">{{$folder->folder}}</option>
      @endif
    @endforeach
  </select>
</div>
<div class='form-group '>
  <label for="individual_id">Assigned to</label>
  <select id="individual_id" name="individual_id">
    <option></option>
    @foreach ($project->individuals as $indiv)
      @if ($indiv->id==$action->individual_id)
        <option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
      @else
        <option value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
      @endif
    @endforeach
  </select>
</div>
{{ Form::bsHidden('project_id',$action->project_id) }}
<div class='form-group '>
  <label for="context">Context</label>
  <select name="context" class="selectize">
  @foreach ($tags as $tag)
    @if ((count($atags)) and (in_array($tag->name,$atags)))
        <option selected value="{{$tag->name}}">{{$tag->name}}</option>
    @else
        <option value="{{$tag->name}}">{{$tag->name}}</option>
    @endif
  @endforeach
  </select>
</div>