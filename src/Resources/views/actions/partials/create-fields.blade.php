{{ Form::bsText('description','Description','Description') }}
{{ Form::bsHidden('user_id',Auth::user()->id) }}
<div class='form-group '>
  <label for="folder_id">Status</label>
  <select id="folder_id" name="folder_id">
    <option></option>
    @foreach ($folders as $folder)
      <option value="{{$folder->id}}">{{$folder->folder}}</option>
    @endforeach
  </select>
</div>
<div class='form-group '>
  <label for="individual_id">Assigned to</label>
  <select id="individual_id" name="individual_id">
    <option></option>
    @foreach ($individuals as $indiv)
      <option value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
    @endforeach
  </select>
</div>
<div class='form-group '>
  <label for="project_id">Project</label>
  <select id="project_id" name="project_id">
    <option></option>
    @foreach ($projects as $project)
      @if ($project->id==$proj)
        <option selected value="{{$project->id}}">{{$project->description}}</option>
      @else
        <option value="{{$project->id}}">{{$project->description}}</option>
      @endif
    @endforeach
  </select>
</div>
<div class='form-group '>
  <label for="context">Context</label>
  <select name="context" class="selectize">
  @foreach ($tags as $tag)
    <option value="{{$tag->name}}">{{$tag->name}}</option>
  @endforeach
  </select>
</div> 