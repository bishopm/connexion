@extends('adminlte::page')

@section('content')
    {{ Form::pgHeader('Add setting','Settings',route('admin.settings.index')) }}
    {!! Form::open(['route' => array('admin.settings.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::settings.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.settings.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop