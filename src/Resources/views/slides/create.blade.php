@extends('adminlte::page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/colorbox.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add slide','Slides',route('admin.slides.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.slides.store'), 'method' => 'post', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::slides.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.slides.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('/vendor/bishopm/js/jquery.colorbox-min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/standalonepopup.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(".browser").colorbox();
        });
    </script>
@stop