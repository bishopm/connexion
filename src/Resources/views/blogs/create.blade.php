@extends('adminlte::page')

@section('content')
    {{ Form::pgHeader('Add blog post','Blogs',route('admin.blogs.index')) }}
    {!! Form::open(['route' => array('admin.blogs.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::blogs.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.blogs.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop