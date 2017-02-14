@extends('app')

@section('content')
<div class="box box-default">
    @include('shared.messageform')
    <div class="box-header">
        <h1 class="box-title">Add a new meeting <small>{{Helpers::getSetting('circuit_name')}} Circuit</small></h1>
    </div>
    {!! Form::open(array('route' => array('meetings.store'), 'class' => 'form-horizontal', 'role' => 'form')) !!}
    @include('meetings.form', array('is_new'=>true))
    <div class="box-footer">
        {!! Form::submit('Add meeting', array('class'=>'btn btn-danger')) !!} <a href="{{url('/meetings')}}" class="btn btn-danger">Cancel</a>
    </div>
</div>
{!! Form::close() !!}

@stop
