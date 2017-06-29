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
                    <button type="button" class="btn btn-danger btn-flat pull-right" data-action-entity="Statistic" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.statistics.destroy', $statistic->id) }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.delete-modal')
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
    @include('connexion::shared.delete-modal-script')
</script>
@stop