@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Add resource','Resources',route('admin.resources.index')) }}
@stop

@section('content')
    {!! Form::open(['route' => array('admin.resources.store'), 'method' => 'post', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::resources.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.resources.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop