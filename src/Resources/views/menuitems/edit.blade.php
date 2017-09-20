@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit menuitem','Menuitems',route('admin.menuitems.index',$menu)) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.menuitems.update',$menu,$menuitem->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-6">
            <a href="{{route('admin.menuitems.create',$menu)}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add a new menuitem item</a>
        </div>
        <div class="col-md-6">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::menuitems.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.menuitems.index',$menu)) }}
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
        $('.selectize').selectize({
          plugins: ['remove_button'],
          openOnFocus: 1,
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