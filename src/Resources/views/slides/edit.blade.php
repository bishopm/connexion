@extends('connexion::templates.backend')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link href="{{ asset('/vendor/bishopm/css/croppie.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit slide','Slideshow',route('admin.slideshows.show',$slide->slideshow_id)) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.slides.update',$slide->id), 'method' => 'put', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::slides.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.slides.index')) }}
                    <button type="button" class="btn btn-danger btn-flat pull-right" data-action-entity="{{$slide->title}}" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.slides.destroy', [$slide->id]) }}">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.filemanager-modal',['folder'=>'slides'])
    @include('connexion::shared.delete-modal')    
@stop

@section('js')
<script src="{{ asset('/vendor/bishopm/js/croppie.js') }}" type="text/javascript"></script>
<script>
    @include('connexion::shared.filemanager-modal-script',['folder'=>'slides','width'=>$slide->slideshow->width,'height'=>$slide->slideshow->height])
    @include('connexion::shared.delete-modal-script')
</script>
@endsection