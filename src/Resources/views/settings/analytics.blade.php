@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    <h2>Google Analytics</h2>
                </div>
                <div class="box-body">
                    {{$analytics}}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop