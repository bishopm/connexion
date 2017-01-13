@extends('app')

@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        @include('shared.messageform')
        <h1>{{$song->title}}</h1>
    </div>
    {!! Form::model($song,array('route' => array('songs.update', $song->id), 'method' => 'put', 'class' => 'form-horizontal', 'role' => 'form')) !!}
    @include('songs.form', array('is_new'=>false))
    <div class="box-footer">
        {!! Form::submit('Update song', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/songs" class="pull-right btn btn-default">Back to index</a>
        {!! Form::close() !!}
        @if (Helpers::perm('admin'))
            {!! Form::open(['method'=>'delete','style'=>'display:inline;','route'=>['songs.destroy', $song->id]]) !!}
            {!! Form::submit('Delete',array('class'=>'btn btn-default','onclick'=>'return confirm("Are you sure you want to delete this song?")')) !!}
            {!! Form::close() !!}
        @endif
    </div>
</div>
@stop
