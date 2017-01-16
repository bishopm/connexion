@extends('base::worship.page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
{{ Form::pgHeader('Add set','Sets',route('admin.sets.index')) }}
@stop

@section('content')
    @include('base::shared.errors')    
    {!! Form::open(['route' => array('admin.sets.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::sets.partials.create-fields')
                    <div class="form-group">
                        <label for="service_id" class="control-label">Service</label>
                        <select name="service_id" class="selectize">
                            <option></option>
                            @foreach ($services as $service)
                               <option value="{{$service->id}}">{{$service->servicetime}} ({{$society}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.sets.index')) }}
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
          });
          $(function() {
            $("#servicedate").datepicker({
              todayHighlight: true,
              format: "yyyy-mm-dd",
              useCurrent: true
            });
          });
      });
    </script>

@stop
