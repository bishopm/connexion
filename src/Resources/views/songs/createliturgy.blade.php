@extends('connexion::worship.page')

@section('css')
  <link href="{{ asset('/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
@include('connexion::shared.errors')
<div class="box box-default">
    <div class="box-header with-border">
        <h3>Create new liturgy</h3>
    </div>
    {!! Form::open(array('route' => array('admin.songs.store'), 'class' => 'form-horizontal', 'role' => 'form', 'id'=>'songform', 'files'=>'true')) !!}
    <div class="box-body">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('title','Title', array('class'=>'control-label')) !!}
            <input type="text" name="title" class="form-control">
        </div>
        <div class="col-sm-6">
            {!! Form::label('author','Author', array('class'=>'control-label')) !!}
            <input type="text" name="author" class="form-control">
        </div>
    </div>
    <br>
    {!! Form::label('lyrics','Text', array('class'=>'control-label')) !!}
    <div name="lyrics" id="lyrics"></div>
    <div class="box-footer">
        {!! Form::submit('Add liturgy', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/songs" class="btn btn-default">Cancel</a>
    </div>
{!! Form::close() !!}
</div>
@stop

@section('js')
	@include('connexion::worship.partials.scripts')
	<script src="{{ asset('vendor/bishopm/summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$('#lyrics').summernote({
    		btns: [['bold']]
		});
	</script>
@stop