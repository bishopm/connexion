@extends('adminlte::page')

@section('content_header')
{{ Form::pgHeader('Edit supplier','Suppliers',route('admin.suppliers.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.suppliers.update',$supplier->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::suppliers.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.suppliers.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop