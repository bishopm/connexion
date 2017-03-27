@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Edit resource','Courses',route('admin.courses.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.courses.update',$course->id), 'method' => 'put', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::courses.partials.edit-fields')
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">Update</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{route('admin.courses.index')}}"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
    });
    $("#removeMedia").on('click',function(e){
        e.preventDefault();
        $.ajax({
            type : 'GET',
            url : '{{url('/')}}/admin/courses/<?php echo $course->id;?>/removemedia',
            success: function(){
              $('#thumbdiv').hide();
              $('#filediv').show();
            }
        });
    });
    $( document ).ready(function() {
            $('#title').on('input', function() {
                var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
                $("#slug").val(slug);
            });
        });
</script>
@endsection