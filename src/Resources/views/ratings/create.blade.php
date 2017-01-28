@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Add rating',$resource->title,route('admin.resources.show',$resource->id)) }}
@stop

@section('content')
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.ratings.store',$resource->id), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::ratings.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.resources.show',$resource->id)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
  <script src="{{url('/')}}/vendor/bishopm/bootstrap-rating-input/bootstrap-rating-input.min.js" type="text/javascript"></script>
@stop