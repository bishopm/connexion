@extends('connexion::worship.page')

@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        @include('connexion::shared.errors')
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

@section('js')
    @include('connexion::worship.partials.scripts')
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.input-tags').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 30,
              dropdownParent: "body",
              create: function(value) {
                  return {
                      value: value,
                      text: value
                  }
              }
            });
            $('#musictype').on('change', function(event){
                alert(event);
                if (event.target.value=='liturgy'){
                    $('#lyrics').summernote();
                    $('#musicrow1').addClass('hidden');
                    $('#musicrow2').addClass('hidden');
                    $('#musicrow3').addClass('hidden');
                } else {
                    $('#lyrics').summernote('destroy');
                    $('#musicrow1').removeClass('hidden');
                    $('#musicrow2').removeClass('hidden');
                    $('#musicrow3').removeClass('hidden');
                }
            });
        });
    </script>
@stop
