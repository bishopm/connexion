@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('Edit sermon',$sermon->series->title,route('admin.series.show',$series)) }}
@endsection

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.sermons.update',$series,$sermon->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::sermons.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.series.show',$series)) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('/vendor/bishopm/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script language="javascript">
        function neaten(event){
            if(event.target){
                //firefox, safari
                myObj = document.getElementById(event.target.id);
                myObj.value=myObj.value.replace(/^https?:\/\//, '');
            } else {
                //IE
                myObj = document.getElementById(event.srcElement.id);
                myObj.value=myObj.value.replace(/^https?:\/\//, '');
            }
        }
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.selectize').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0
            });
            $("#servicedate").datepicker({
              todayHighlight: true,
              format: "yyyy-mm-dd"
            });
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
                $.ajax({ url: "{{url('/')}}/admin/sermons/addtag/{{$sermon->id}}/" + value })
              },
              onItemRemove: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/sermons/removetag/{{$sermon->id}}/" + value })
              }
            });
            $('#title').on('input', function() {
                var slug = $("#title").val().toString().trim().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "");
                $("#slug").val(slug);
            });
        });
    </script>
@stop