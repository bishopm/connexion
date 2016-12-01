<div class="box-body">
  {!! Form::normalInput('description', 'Description', $errors, $action) !!}
  <div class='form-group '>
    <label for="folder_id">Folder</label>
    <select id="folder_id" name="folder_id">
      <option></option>
      @foreach ($folders as $folder)
        @if ($action->folder_id==$folder->id)
            <option selected value="{{$folder->id}}">{{$folder->folder}}</option>
        @else
            <option value="{{$folder->id}}">{{$folder->folder}}</option>
        @endif
      @endforeach
    </select>
  </div>
  {!! Form::normalInput('status_details', 'Status details', $errors, $action) !!}
  <div class='form-group '>
    <label for="individual_id">Action owner</label>
    <select id="individual_id" name="individual_id">
      <option></option>
      @foreach ($individuals as $indiv)
        @if ($action->individual_id==$indiv->id)
          <option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
        @else
          <option value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
        @endif
      @endforeach
    </select>
  </div>
  <div class='form-group '>
    <label for="project_id">Project</label>
    <select id="project_id" name="project_id">
      <option></option>
      @foreach ($projects as $project)
        @if ($action->project_id==$project->id)
          <option selected value="{{$project->id}}">{{$project->description}}</option>
        @else
          <option value="{{$project->id}}">{{$project->description}}</option>
        @endif
      @endforeach
    </select>
  </div>
</div>
