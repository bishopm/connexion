@extends('adminlte::page')

@section('content')
    {{ Form::pgHeader('Edit permission','Permissions',route('admin.permissions.index')) }}
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.permissions.update',$permission->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::permissions.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.permissions.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop