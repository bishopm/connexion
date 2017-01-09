@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Add menu','Menus',route('admin.menus.index')) }}
@stop

@section('content')
    @include('base::shared.errors')
    {!! Form::open(['route' => array('admin.menus.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::menus.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.menus.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop