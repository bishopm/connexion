@extends('adminlte::page')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{asset('/vendor/bishopm/css/bootstrap-datepicker.min.css')}}">
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
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.filemanager-modal',['folder'=>'individuals/' . $individual->id])
@stop

@section('js')
<script src="{{asset('/vendor/bishopm/js/bootstrap-datepicker.min.js')}}"></script>
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
    $("#removeMedia").on('click',function(e){
        e.preventDefault();
        $.ajax({
            type : 'GET',
            url : '{{url('/')}}/admin/individuals/<?php echo $individual->id;?>/removemedia',
            success: function(){
              $('#thumbdiv').hide();
              $('#filediv').show();
            }
        });
    });
    @include('connexion::shared.filemanager-modal-script',['folder'=>'individuals/' . $individual->id,'width'=>250,'height'=>250])
</script>
@endsection