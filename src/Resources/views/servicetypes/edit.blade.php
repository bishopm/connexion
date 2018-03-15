@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
{{ Form::pgHeader('Edit service type','Service types',route('admin.servicetypes.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.servicetypes.update',$servicetype->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::servicetypes.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.servicetypes.index')) }}
                    <button type="button" class="btn btn-danger btn-flat pull-right" data-action-entity="{{$servicetype->description}}" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.servicetypes.destroy', [$servicetype->id]) }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @include('connexion::shared.delete-modal')
    {!! Form::close() !!}
@stop

@section('js')
<script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('.selectize').selectize({
          plugins: ['remove_button'],
          openOnFocus: 0,
          maxOptions: 30,
        });
    });
    @include('connexion::shared.delete-modal-script')
</script>
@stop