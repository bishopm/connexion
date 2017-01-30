@extends('app')

@section('content')
	@include('shared.messageform')
	{!! Form::model($roster, array('route' => array('society.rosters.update', $society,$roster->id), 'method' => 'put', 'class' => 'form-horizontal', 'role' => 'form')) !!}
	<div class="box box-default">
		<div class="box-header">
			<h3 class="box-title">Edit roster: {{$roster->rostername}}</h3>
		</div>
		@include('rosters.form', array('is_new'=>false))
		<div class="box-footer">
			{!! Form::submit('Update changes', array('class'=>'btn btn-danger')) !!}
			<a href="{{url('/')}}/{{$society}}/rosters" class="btn btn-danger">Cancel</a>
		</div>
	</div>
	{!! Form::close() !!}
@stop
