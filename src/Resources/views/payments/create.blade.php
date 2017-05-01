@extends('adminlte::page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add payment','Payments',route('admin.payments.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.payments.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    <div class="form-group">
                        <label for="service_id" class="control-label">Planned giving number</label>
                        <select name="pgnumber" class="selectize">
                            <option></option>
                            @foreach ($pgs as $pg)
                               <option value="{{$pg}}">{{$pg}}</option>
                            @endforeach
                        </select>
                    </div>
                    @include('connexion::payments.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.payments.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
          $('.selectize').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 10,
              dropdownParent: "body",
              create: function(value) {
                  return {
                      value: value,
                      text: value
                  }
              }
          });
          $(function() {
            $("#paymentdate").datepicker({
              todayHighlight: true,
              format: "yyyy-mm-dd",
              useCurrent: true
            });
          });
      });
    </script>
@stop