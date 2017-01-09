@extends('adminlte::page')

@section('content')
    {{ Form::pgHeader('Add role','Roles',route('admin.roles.index')) }}
    @include('base::shared.errors')    
    {!! Form::open(['route' => array('admin.roles.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::roles.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.roles.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop