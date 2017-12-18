{{ Form::bsText('description','Description','Description') }}
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
    @foreach ($project->individuals as $indiv)
      @if ($project->individuals->contains($indiv->id))
        <option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
      @else
        <option value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
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
{{ Form::bsHidden('user_id',Auth::user()->id) }}