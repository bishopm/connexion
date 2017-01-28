@extends('adminlte::page')

@section('content_header')
    {{ Form::pgHeader('Edit series','Series',route('admin.series.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.series.update',$series->id), 'method' => 'put', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::series.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.series.index')) }}
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
            url : '{{url('/')}}/admin/series/<?php echo $series->id;?>/removemedia',
            success: function(){
              $('#thumbdiv').hide();
              $('#filediv').show();
            }
        });
    });
</script>
@endsection