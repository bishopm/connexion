@extends('app')

@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        @include('shared.messageform')
        <h1>{{$chord->chordname}}</h1>
    </div>
    <div class="box-body">
        {!! Form::model($chord,array('route' => array('chords.update', $chord->id), 'method' => 'put', 'class' => 'form-horizontal', 'role' => 'form')) !!}
        @include('chords.form', array('is_new'=>false))
    </div>
    <div class="box-footer">
        @if (Helpers::perm('edit'))
            {!! Form::submit('Update chord', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/chords" class="pull-right btn btn-default">Back to index</a>
            {!! Form::close() !!}
            {!! Form::open(['method'=>'delete','style'=>'display:inline;','route'=>['chords.destroy', $chord->id]]) !!}
            {!! Form::submit('Delete',array('class'=>'btn btn-default','onclick'=>'return confirm("Are you sure you want to delete this chord?")')) !!}
            {!! Form::close() !!}
        @endif
    </div>
</div>
@stop
