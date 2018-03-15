@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
{{ Form::pgHeader('Edit society','Societies',route('admin.societies.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.societies.update',$society->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::societies.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.societies.index')) }}
                    <a onclick="deleteboxes();" class="btn btn-danger btn-flat pull-right"><i class="fa fa-trash"></i>Delete society</a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{url('/')}}/vendor/bishopm/js/gmap.js" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            google.maps.event.addDomListener(window, 'load', initialize(14));
        });
        function deleteboxes() {
            $('.selectize').selectize({
                plugins: ['remove_button'],
                openOnFocus: 0,
                maxOptions: 30,
            });
            $('#deletetype').show();
            $('#deletenotes').show();
        }
    </script>
@stop