@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/vendor/bishopm/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit an event','Events',route('admin.events.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => ['admin.events.update',$event->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::events.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.events.index')) }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="map_canvas" style="height:350px;">
            </div>
            {{ Form::bsText('latitude','Latitude','Latitude',$event->latitude) }}
            {{ Form::bsText('longitude','Longitude','Longitude',$event->longitude) }}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{url('/')}}/public/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
    <script src="{{ asset('public/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/vendor/bishopm/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            google.maps.event.addDomListener(window, 'load', initialize(12));
        });
        $('#leader').selectize();
        $('#eventdatetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });
    </script>
@stop