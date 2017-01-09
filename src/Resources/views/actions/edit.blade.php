@extends('adminlte::page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit task','Tasks',route('admin.actions.index')) }}
@stop

@section('content')
    @include('base::shared.errors')
    {!! Form::open(['route' => array('admin.actions.update',$action->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::actions.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.actions.index')) }}
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
        $('#project_id').selectize({
          plugins: ['remove_button'],
          openOnFocus: 1,
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
          },
          onItemAdd: function(value,$item) {
            $.ajax({ url: "{{url('/')}}/admin/actions/addtag/{{$action->id}}/" + value })
          },
          onItemRemove: function(value,$item) {
            $.ajax({ url: "{{url('/')}}/admin/actions/removetag/{{$action->id}}/" + value })
          }
        });
    });
</script>
@stop