@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Add slide','Slides',route('admin.slides.index')) }}
@stop

@section('content')
    @include('base::shared.errors')
    {!! Form::open(['route' => array('admin.slides.store'), 'method' => 'post', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::slides.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.slides.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop