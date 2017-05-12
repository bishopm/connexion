@extends('connexion::templates.backend')

@section('css')
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('/public/vendor/bishopm/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
{{ Form::pgHeader('Add transaction','Transactions',route('admin.transactions.index')) }}
@stop

@section('content')
    {!! Form::open(['route' => array('admin.transactions.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            @include('connexion::shared.errors')    
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::transactions.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.transactions.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('public/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.selectize').selectize();
            $(function() {
                $("#transactiondate").datepicker({
                  todayHighlight: true,
                  format: "yyyy-mm-dd",
                  useCurrent: true
                });
              });
        });
    </script>
@stop
