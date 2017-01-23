@extends('base::worship.page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
@include('base::shared.errors')
<div class="box box-default">
    <div class="box-header with-border">
        <h3>Create a new song</h3>
    </div>
    {!! Form::open(array('route' => array('admin.songs.store'), 'class' => 'form-horizontal', 'role' => 'form', 'files'=>'true')) !!}
    @include('base::songs.form', array('is_new'=>true))
    <div class="box-footer">
        {!! Form::submit('Add song', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/songs" class="btn btn-default">Cancel</a>
    </div>
{!! Form::close() !!}
</div>
@stop

@section('js')
	@include('base::worship.partials.scripts')
	<script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
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
        });
    </script>
@stop