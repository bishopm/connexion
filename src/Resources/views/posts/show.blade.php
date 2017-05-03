@extends('connexion::templates.webpage')

@section('css')
    <link href="{{ asset('/public/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="container">
        {{ Form::pgHeader($post->title,'Forum',route('posts.index')) }}
        @include('connexion::shared.errors')    
        {!! Form::open(['route' => array('posts.store'), 'method' => 'post']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"> 
                    <div class="box-body">
                        @include('connexion::posts.partials.create-fields',['reply'=>'true'])
                    </div>
                    <div class="box-footer">
                        {{Form::pgButtons('Reply',route('posts.index')) }}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('js')
    <script src="{{ asset('public/vendor/bishopm/summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#body').summernote({ 
              height: 250,
              toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['table', ['table']],
                ['link', ['linkDialogShow', 'unlink']],
                ['view', ['fullscreen', 'codeview']],
                ['para', ['ul', 'ol', 'paragraph']]
              ]
            });
        });
    </script>
@stop