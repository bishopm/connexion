@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader($project->description . ': Add task','Tasks',route('admin.actions.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.actions.store',$project->id), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::actions.partials.create-fields')
                    {{ Form::bsHidden('project_id',$project->id) }}
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
        $('#individual_id').selectize({
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