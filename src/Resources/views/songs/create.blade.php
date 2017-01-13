@extends('app')

@section('content')
@include('shared.messageform')
<div class="box box-default">
    <div class="box-header with-border">
        <h3>Create a new song</h3>
    </div>
    {!! Form::open(array('route' => array('songs.store'), 'class' => 'form-horizontal', 'role' => 'form', 'files'=>'true')) !!}
    @include('songs.form', array('is_new'=>true))
    <div class="box-footer">
        {!! Form::submit('Add song', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/songs" class="btn btn-default">Cancel</a>
    </div>
{!! Form::close() !!}
</div>
@stop
