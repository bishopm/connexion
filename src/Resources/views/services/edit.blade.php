@extends('connexion::templates.backend')

@section('content_header')
    {{ Form::pgHeader('Edit service','Services',route('admin.services.index',$society)) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.services.update',$society,$service), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::services.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.services.index',$society)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop