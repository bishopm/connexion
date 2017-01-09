@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Add series','Series',route('admin.series.index')) }}
@stop

@section('content')
    @include('base::shared.errors')
    {!! Form::open(['route' => array('admin.series.store'), 'method' => 'post', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::series.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.series.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop