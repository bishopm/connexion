@extends('app')

@section('content')
@include('shared.messageform')
<div class="box box-default">
    <div class="box-header with-border">
        <h3>New set</h3>
    </div>
    {!! Form::open(array('route' => array('sets.store'), 'class' => 'form-horizontal', 'role' => 'form', 'files'=>'true')) !!}
    @include('sets.form', array('is_new'=>true))
    <div class="box-footer">
        {!! Form::submit('Add set', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/sets" class="btn btn-default">Cancel</a>
    </div>
{!! Form::close() !!}
</div>
@stop
