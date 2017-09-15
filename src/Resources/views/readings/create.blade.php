@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add reading','Readings',route('admin.readings.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.readings.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::readings.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.readings.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
          $('.selectize').selectize();
          $(function() {
            $("#readingdate").datepicker({
              todayHighlight: true,
              format: "yyyy-mm-dd",
              useCurrent: true
            });
          });
      });
    </script>
@stop