@extends('adminlte::page')

@section('content_header')
{{ Form::pgHeader('Edit sermon',$sermon->series->series,route('admin.series.show',$series)) }}
@endsection

@section('content')
    {!! Form::open(['route' => array('admin.sermons.update',$series,$sermon->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::sermons.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.series.show',$series)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop