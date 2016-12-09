@extends('adminlte::page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit project','Projects',route('admin.projects.index')) }}
@stop

@section('content')
    {!! Form::open(['route' => array('admin.projects.update',$project->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::projects.partials.edit-fields')
                    <div class="form-group">
                        <label for="individual_id" class="control-label">Leader</label>
                        <select name="individual_id" class="input-leader">
                          @foreach ($individuals as $indiv)
                            @if ($indiv->id==$project->individual_id)
                                <option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
                            @else
                                <option value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
                            @endif
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.projects.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
<script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('.input-leader').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
        });
    });
</script>
@stop