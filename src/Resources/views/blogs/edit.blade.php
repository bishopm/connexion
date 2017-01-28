@extends('adminlte::page')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit blog post','Blogs',route('admin.blogs.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.blogs.update',$blog->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::blogs.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.blogs.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
        });    
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
              },
              onItemAdd: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/blogs/addtag/{{$blog->id}}/" + value })
              },
              onItemRemove: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/blogs/removetag/{{$blog->id}}/" + value })
              }
            });             
            $('.selectize').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0
            });
        });
    </script>
@stop