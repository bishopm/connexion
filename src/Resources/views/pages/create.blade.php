@extends('adminlte::page')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Add page','Pages',route('admin.pages.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.pages.store'), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::pages.partials.create-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Create',route('admin.pages.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
<script src="{{ asset('vendor/bishopm/summernote/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
<script langugage="javascript">
$(document).ready(function()
{
    $('#title').on('input', function() {
        var title = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
        $("#slug").val(title);
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
    $('.selectize').selectize({
      plugins: ['remove_button'],
      openOnFocus: 0
    }); 
});
</script>
@stop