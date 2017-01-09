@extends('adminlte::page')

@section('content')
    {{ Form::pgHeader('Add folder','Folders',route('admin.folders.index')) }}
    @include('base::shared.errors')    
    {!! Form::open(['route' => array('admin.folders.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::folders.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.folders.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop