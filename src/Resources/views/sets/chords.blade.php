@extends('app')

@section('content')
<h1>Guitar chords</h1>
@if (@getimagesize($fullname))
    <img src="{{$fullname}}">
@elseif (isset($fullname))
    <h3>{{str_replace('_','/',$chord)}}</h3>
    This chord does not exist on the system - please add it now
@else
    Add a new chord
@endif
{!! Form::open(array('route' => array('chords',$chord), 'method'=>'get', 'class' => 'form-horizontal', 'role' => 'form')) !!}
{!! Form::label('chord','Chord name (eg: A)', array('class'=>'control-label')) !!}
{!! Form::text('chord', str_replace('_','/',$chord), array('class' => 'form-control')) !!}
{!! Form::label('strings','String (eg: x02220)', array('class'=>'control-label')) !!}
{!! Form::text('strings', null, array('class' => 'form-control')) !!}
{!! Form::label('barre','Barre (eg: 216 - 2nd fret, strings 1 to 6) Leave blank for none', array('class'=>'control-label')) !!}
{!! Form::text('barre', null, array('class' => 'form-control')) !!}
{!! Form::submit('Add chord', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/chords" class="btn btn-default">Cancel</a>
{!! Form::close() !!}
@stop
