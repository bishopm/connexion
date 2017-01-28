@extends('connexion::worship.page')

@section('content')
@include('connexion::shared.errors')
<div class="box box-default">
    <div class="box-header with-border">
        <h3>New chord</h3>
    </div>
    <div class="box-body">
        {!! Form::open(array('route' => array('admin.chords.store'), 'class' => 'form-horizontal', 'role' => 'form', 'files'=>'true')) !!}
        @include('connexion::chords.form', array('is_new'=>true))
    </div>
    <div class="box-footer">
        {!! Form::submit('Add chord', array('class'=>'btn btn-default')) !!} <a href="{{url('/')}}/chords" class="btn btn-default">Cancel</a>
    </div>
{!! Form::close() !!}
</div>
@stop

@section('js')
@include('connexion::worship.partials.scripts')
@endsection
