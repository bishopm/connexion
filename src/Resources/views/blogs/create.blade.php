@extends('adminlte::page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add blog post','Blogs',route('admin.blogs.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.blogs.store'), 'method' => 'post','files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::blogs.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.blogs.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.input-tags').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 30,
              dropdownParent: "body",
              create: function(value) {
                  return {
                      value: value,
                      text: value
                  }
              }
            });            
            $('.selectize').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0
            });            
            $('#body').summernote({ 
              height: 250,
              toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['table', ['table']],
                ['link', ['linkDialogShow', 'unlink']],
                ['para', ['ul', 'ol', 'paragraph']]
              ]
            });
            $('#title').on('input', function() {
                var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
                $("#slug").val(slug);
            });
        });
    </script>
@stop