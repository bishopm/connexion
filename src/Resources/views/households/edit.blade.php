@extends('connexion::templates.backend')

@section('content_header')
    {{ Form::pgHeader($household->addressee,'Households',route('admin.households.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => ['admin.households.update', $household->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::households.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.households.index')) }}
                    <button type="button" class="btn btn-danger btn-flat pull-right" data-action-entity="{{$household->addressee}}" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.households.destroy', [$household->id]) }}">Delete</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="map_canvas" style="height:350px;">
            </div>
            {{ Form::bsText('latitude','Latitude','Latitude',$household->latitude) }}
            {{ Form::bsText('longitude','Longitude','Longitude',$household->longitude) }}
            {{ Form::bsText('sortsurname','Sort by (Household Surname)','Sort by (Household Surname)',$household->sortsurname) }}
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.delete-modal')
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{url('/')}}/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            google.maps.event.addDomListener(window, 'load', initialize(12));
        });
        @include('connexion::shared.delete-modal-script')
    </script>
@stop
