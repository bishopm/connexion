@extends('adminlte::page')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
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
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#title').on('input', function() {
                var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
                $("#slug").val(slug);
            });
        });
        @include('connexion::shared.filemanager-modal-script',['folder'=>'courses','width'=>250,'height'=>250])
    </script>
@stop 