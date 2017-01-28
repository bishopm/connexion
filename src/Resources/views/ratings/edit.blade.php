@extends('adminlte::page')

@section('content')
    {{ Form::pgHeader('Update rating','$resource->title',route('admin.resources.show',$resource->id)) }}
    @include('connexion::shared.errors')    
    {!! Form::open(['route' => array('admin.ratings.update'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::ratings.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.resource.show',$resource->id)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
  <script src="{{url('/')}}/vendor/bishopm/bootstrap-rating-input/bootstrap-rating-input.min.js" type="text/javascript"></script>
@stop