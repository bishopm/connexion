@extends('adminlte::page')

@section('content_header')
{{ Form::pgHeader('Add role','Roles',route('admin.roles.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.roles.update',$role->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::roles.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.roles.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop