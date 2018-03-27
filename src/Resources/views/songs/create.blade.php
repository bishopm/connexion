@extends('connexion::worship.page')

@section('css')
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.css" rel="stylesheet">
@stop

@section('content')
@include('connexion::shared.errors')
<div class="box box-default">
    <div class="box-header with-border">
        <h3>Create a new song</h3>
    </div>
    {!! Form::open(array('route' => array('admin.songs.store'), 'class' => 'form-horizontal', 'role' => 'form', 'files'=>'true')) !!}
    @include('connexion::songs.form', array('is_new'=>true))
    <div class="box-footer">
        {!! Form::submit('Add song', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/songs" class="btn btn-default">Cancel</a>
    </div>
{!! Form::close() !!}
</div>
@stop

@section('js')
	@include('connexion::worship.partials.scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.js"></script>
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