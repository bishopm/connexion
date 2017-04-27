@extends('adminlte::page')

@section('content_header')
{{ Form::pgHeader('Add folder','Folders',route('admin.folders.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.folders.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::folders.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.folders.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop