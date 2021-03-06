@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add a group','Groups',route('admin.groups.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors') 
    {!! Form::open(['route' => ['admin.groups.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::groups.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.groups.index')) }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="map_canvas" style="height:350px;">
            </div>
            @if (($setting['home_latitude'] <> 'Church latitude') and ($setting['home_longitude'] <> 'Church longitude'))
                {{ Form::bsText('latitude','Latitude','Latitude',$setting['home_latitude']) }}             
                {{ Form::bsText('longitude','Longitude','Longitude',$setting['home_longitude']) }}
            @else
                {{ Form::bsText('latitude','Latitude','Latitude') }}
                {{ Form::bsText('longitude','Longitude','Longitude') }}
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{url('/')}}/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>    
    <script type="text/javascript">
        $( document ).ready(function() {
            google.maps.event.addDomListener(window, 'load', initialize(12));
        });
        $('#leader').selectize();
        $('#groupname').on('input', function() {
            var slug = $("#groupname").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
            $("#slug").val(slug);
        });
    </script>
@stop