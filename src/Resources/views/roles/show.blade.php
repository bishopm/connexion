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
          <div class="col-md-12"><p>{{$role->description}}</p></div>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <h4>Role permissions</h4>
            <select class="input-roles" multiple>
              @foreach ($role->permissions as $pp)
                <option selected value="{{$pp->id}}">{{$pp->name}}</option>
              @endforeach
              @foreach ($permissions as $perm)
                <option value="{{$perm->id}}">{{$perm->name}}</option>
              @endforeach
            </select>
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