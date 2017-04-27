@extends('adminlte::page')

@section('content_header')
{{ Form::pgHeader('Add supplier','Suppliers',route('admin.suppliers.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.suppliers.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::suppliers.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.suppliers.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop