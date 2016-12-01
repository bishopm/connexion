@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Add a household','Households',route('admin.households.index')) }}
@stop

@section('content')
    {!! Form::open(['route' => ['admin.households.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::households.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.households.index')) }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="map_canvas" style="height:350px;">
            </div>
            {{ Form::bsText('latitude','Latitude','Latitude',$setting['home_latitude']) }}
            {{ Form::bsText('longitude','Longitude','Longitude',$setting['home_longitude']) }}
            {{ Form::bsText('sortsurname','Sort by (Household Surname)','Sort by (Household Surname)') }}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{url('/')}}/js/gmap.js" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            google.maps.event.addDomListener(window, 'load', initialize(12));
        });
        $("#addressee").change(function () {
            $('#sortsurname').val($("#addressee").val().split(" ").splice(-1));
        });
    </script>
@stop
