@extends('connexion::templates.backend')

@section('content_header')
{{ Form::pgHeader('Add service','Services',route('admin.services.index',$society->id)) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.services.store',$society->id), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::services.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.services.index',$society->id)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop