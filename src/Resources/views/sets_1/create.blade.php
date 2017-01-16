@extends('base::worship.page')

@section('content')
@include('base::shared.errors')
<div class="box box-default">
    <div class="box-header with-border">
        <h3>New set</h3>
    </div>
    {!! Form::open(array('route' => array('admin.sets.store'), 'class' => 'form-horizontal', 'role' => 'form', 'files'=>'true')) !!}
    @include('base::sets.form', array('is_new'=>true))
    <div class="box-footer">
        {!! Form::submit('Add set', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/sets" class="btn btn-default">Cancel</a>
    </div>
{!! Form::close() !!}
</div>
@stop
@section('js')
    <script src="{{ asset('vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>    
    <script type="text/javascript">
    $( document ).ready(function() {
          $(function() {
            $("#servicedate").datepicker({
              todayHighlight: true,
              format: "yyyy-mm-dd",
              useCurrent: true
            });
          });
          $('.selectize').selectize({
	          openOnFocus: 0,
	          maxOptions: 10,
	          dropdownParent: "body",
          });
      });
    </script>
@stop
