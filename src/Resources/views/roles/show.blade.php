@extends('adminlte::page')

@section('css')
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
    {{ Form::pgHeader('','Roles',route('admin.roles.index')) }}
@stop

@section('content')
@include('connexion::shared.errors') 
    <div class="box box-primary"> 
      <div class="box-header">
        <div class="row">
          <div class="col-md-6"><h4>Role: {{$role->name}}</h4></div>
          <div class="col-md-6">
            <a href="{{route('admin.roles.edit',$role->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit role</a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <ul class="list-unstyled">
              @foreach ($users as $user)
                <li>{{$user->individual->firstname}} {{$user->individual->surname}}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('public/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.input-roles').selectize({
              plugins: ['remove_button'],
              openOnFocus: 1,
              maxOptions: 30,
              onItemAdd: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/roles/{{$role->id}}/addpermission/" + value })
              },
              onItemRemove: function(value,$item) {
                $.ajax({ url: "{{url('/')}}/admin/roles/{{$role->id}}/removepermission/" + value })
              }
            });
        });
    </script>
@stop