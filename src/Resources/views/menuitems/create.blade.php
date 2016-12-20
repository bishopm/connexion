@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Add menuitem','Menuitems',route('admin.menuitems.index',$menu)) }}
@stop

@section('content')
    {!! Form::open(['route' => array('admin.menuitems.store',$menu), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::menuitems.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.menuitems.index',$menu)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop