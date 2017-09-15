@extends('connexion::templates.backend')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('/vendor/bishopm/css/croppie.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add course','Courses',route('admin.courses.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.courses.store'), 'method' => 'post', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::courses.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.courses.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('connexion::shared.filemanager-modal',['folder'=>'courses'])
@stop

@section('js')
    <script src="{{ asset('/vendor/bishopm/summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/summernote/summernote-cleaner.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/croppie.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#title').on('input', function() {
                var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
                $("#slug").val(slug);
            });
            $('#description').summernote({ 
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
              ],
              cleaner:{
                notTime: 2400, // Time to display Notifications.
                action: 'paste', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
                newline: '<p></p>', // Summernote's default is to use '<p><br></p>'
                notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
                icon: '<i class="note-icon">[Your Button]</i>',
                keepHtml: false, // Remove all Html formats
                keepClasses: false, // Remove Classes
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'font', 'noscript', 'html'], 
                badAttributes: ['style', 'start','p'] // Remove attributes from remaining tags
              }
            });
            $('.selectize').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0
            });
        });
        @include('connexion::shared.filemanager-modal-script',['folder'=>'courses','width'=>250,'height'=>250])
    </script>
@stop 