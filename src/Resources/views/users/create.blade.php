@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{asset('/vendor/bishopm/css/bootstrap-datepicker.min.css')}}">
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    {{ Form::pgHeader('Add user','Users',route('admin.users.index')) }}
    @include('base::shared.errors')    
    {!! Form::open(['route' => array('admin.users.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::users.partials.create-fields')
                    <div class="form-group">
                        <label for="individual_id" class="control-label">Linked to which individual (if any)</label>
                        <select name="individual_id" class="input-individual">
                          <option value="0"></option>
                          @foreach ($individuals as $individual)
                            <option value="{{$individual->id}}">{{$individual->firstname}} {{$individual->surname}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role_id" class="control-label">Role</label>
                        <select name="role_id" class="input-role">
                          @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.users.index')) }}
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
        $('.input-individual').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
        });
        $('.input-role').selectize({
          plugins: ['remove_button'],
          openOnFocus: 1,
          maxOptions: 30,
        });
    });
    $(function () {
      $(".colorpicker").colorpicker();
    });    
</script>
<script src="{{ asset('/public/colorpicker/bootstrap-colorpicker.min.js') }}" type="text/javascript"></script>
@stop 