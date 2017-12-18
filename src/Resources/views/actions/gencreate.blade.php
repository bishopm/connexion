@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add a task',route('admin.actions.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.actions.general.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    {{ Form::bsText('description','Description','Description') }}
                    <div class='form-group '>
                    <label for="project_id">Project</label>
                    <select id="project_id" name="project_id">
                        @foreach ($projects as $project)
                            <option value="{{$project->id}}">{{$project->description}}</option>
                        @endforeach
                    </select>
                    </div>                    
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
                    <label for="context">Context</label>
                    <select name="context" class="selectize">
                    @foreach ($tags as $tag)
                        <option value="{{$tag->name}}">{{$tag->name}}</option>
                    @endforeach
                    </select>
                    </div>
                    {{ Form::bsHidden('user_id',Auth::user()->id) }}
                    {{ Form::bsHidden('individual_id',Auth::user()->individual_id) }}
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.actions.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
<script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('#folder_id').selectize({
          plugins: ['remove_button'],
          openOnFocus: 1,
          maxOptions: 30,
        });
        $('#project_id').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
        });
        $('.selectize').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
          dropdownParent: "body",
          create: function(value) {
              return {
                  value: value,
                  text: value
              }
          }
        });                    
    });
</script>
@stop