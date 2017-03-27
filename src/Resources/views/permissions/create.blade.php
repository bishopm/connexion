@extends('adminlte::page')

@section('content_header')
{{ Form::pgHeader('Add permission','Permissions',route('admin.permissions.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.permissions.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::permissions.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.permissions.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop