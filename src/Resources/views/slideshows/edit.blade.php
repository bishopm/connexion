@extends('connexion::templates.backend')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link href="{{ asset('/vendor/bishopm/css/croppie.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit slideshow','Slideshows',route('admin.slideshows.show')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.slideshows.update',$slideshow->id), 'method' => 'put', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::slideshows.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.slideshows.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.filemanager-modal',['folder'=>'slideshows'])
@stop

@section('js')
<script src="{{ asset('/vendor/bishopm/js/croppie.js') }}" type="text/javascript"></script>
<script>
    @include('connexion::shared.filemanager-modal-script',['folder'=>'slideshows','width'=>$slideshow->width,'height'=>$slideshow->height])
</script>
@endsection