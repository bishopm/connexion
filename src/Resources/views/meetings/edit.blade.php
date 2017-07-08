@extends('app')

@section('content')
<div class="box box-default">
    @include('shared.errors')
    <div class="box-header">
        <h1 class="box-title">Edit a meeting <small>{{$meeting->description}}</small></h1>
    </div>
    {!! Form::model($meeting,array('route' => array('meetings.update', $meeting->id), 'method' => 'put', 'class' => 'form-horizontal', 'role' => 'form')) !!}
    @include('meetings.form', array('is_new'=>false))
    <div class="box-footer">
        {!! Form::submit('Update meeting', array('class'=>'btn btn-danger')) !!} <a href="{{url('/meetings')}}" class="btn btn-danger">Cancel</a>{!! Form::close() !!}
	    {!! Form::open(['style'=>'display:inline;','method'=>'delete','route'=>['meetings.destroy', $meeting->id]]) !!}
	    {!! Form::submit('Delete',array('class'=>'btn btn-danger','onclick'=>'return confirm("Are you sure you want to delete this meeting?")')) !!}
  	    {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
