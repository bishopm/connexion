@extends('connexion::worship.page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
{{ Form::pgHeader('Create new set from existing','Sets',route('admin.sets.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.sets.duplicatestore'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::sets.partials.create-fields')
                    <div class="form-group">
                        <label for="service_id" class="control-label">Service</label>
                        <select name="servicetime" class="selectize">
                            <option></option>
                            @foreach ($services as $service)
                               <option value="{{$service}}">{{$service}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{ Form::bsHidden('duplicate',$duplicate) }}
                    <div>Note that for any existing set on this date and at this time copied items will be added to the existing set</div>
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Duplicate',route('admin.sets.show',$duplicate)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    @include('connexion::worship.partials.scripts')
    <script src="{{ asset('/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>    
    <script type="text/javascript">
    $( document ).ready(function() {
          $('.selectize').selectize({
              plugins: ['remove_button'],
              openOnFocus: 1,
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
