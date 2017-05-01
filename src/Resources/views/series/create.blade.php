@extends('adminlte::page')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link href="{{ asset('/vendor/bishopm/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add series','Series',route('admin.series.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.series.store'), 'method' => 'post', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::series.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.series.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.filemanager-modal',['folder'=>'series'])
@stop

@section('js')
    <script src="{{ asset('vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#title').on('input', function() {
                var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
                $("#slug").val(slug);
            });
            $('#created_at').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        @include('connexion::shared.filemanager-modal-script',['folder'=>'series','width'=>250,'height'=>250])
    </script>
@stop