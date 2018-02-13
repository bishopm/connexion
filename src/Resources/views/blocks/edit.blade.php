@extends('connexion::templates.backend')

@section('content_header')
    {{ Form::pgHeader('Edit block','Blocks',route('admin.blocks.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.blocks.update',$block->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::blocks.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.blocks.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop