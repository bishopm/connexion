@extends('connexion::templates.backend')

@section('css')
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('/public/vendor/bishopm/icheck/blue.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('/public/vendor/bishopm/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit statistic','Statistics',route('admin.statistics.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.statistics.update',$statistic->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::statistics.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.statistics.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
<script src="{{ asset('public/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/vendor/bishopm/icheck/icheck.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('.selectize').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
        });
        $(function() {
            $("#statdate").datepicker({
              todayHighlight: true,
              format: "yyyy-mm-dd"
            });
        });
        $('.majorservice').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
    });
</script>
@stop