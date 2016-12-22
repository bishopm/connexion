@extends('adminlte::page')

@section('content')
    {{ Form::pgHeader('Add sermon','Sermons',route('admin.series.show',$series_id)) }}
    {!! Form::open(['route' => array('admin.sermons.store',$series_id), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::sermons.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.series.show',$series_id)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop