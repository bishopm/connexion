@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Edit page','Pages',route('admin.pages.index')) }}
@stop

@section('content')
    {!! Form::open(['route' => array('admin.pages.update',$page->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::pages.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.pages.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop