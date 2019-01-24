@extends('connexion::templates.frontend')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.css" rel="stylesheet">
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
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.js"></script>
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