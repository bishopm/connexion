@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit midweek service','Midweek services',route('admin.weekdays.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')  
    {!! Form::open(['route' => array('admin.weekdays.update',$weekday->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::weekdays.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.weekdays.index')) }}
                    <button type="button" class="btn btn-danger btn-flat pull-right" data-action-entity="{{$weekday->description}}" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.weekdays.destroy', [$weekday->id]) }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.delete-modal')
@stop

@section('js')
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#servicedate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        @include('connexion::shared.delete-modal-script')
    </script>
@stop