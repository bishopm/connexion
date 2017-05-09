@extends('adminlte::page')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{asset('/public/vendor/bishopm/css/bootstrap-datepicker.min.css')}}">
    <link href="{{ asset('/public/vendor/bishopm/css/croppie.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader($individual->firstname . ' ' . $individual->surname,$individual->household->addressee,route('admin.households.show',$individual->household_id)) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.individuals.update',$individual->household_id,$individual->id), 'method' => 'put', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::individuals.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.households.show',$individual->household_id)) }}
                    <button class="btn btn-danger btn-flat pull-right" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.individuals.destroy', [$individual->household_id,$individual->id]) }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.filemanager-modal',['folder'=>'individuals/' . $individual->id])
@stop

@section('js')
<script src="{{asset('/public/vendor/bishopm/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('public/vendor/bishopm/js/croppie.js') }}" type="text/javascript"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $(function () {
        $("#birthdate").datepicker({
            format: 'yyyy-mm-dd'
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    @include('connexion::shared.filemanager-modal-script',['folder'=>'individuals/' . $individual->id,'width'=>250,'height'=>250])
</script>
@endsection