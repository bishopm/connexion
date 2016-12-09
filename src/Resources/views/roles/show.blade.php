@extends('adminlte::page')

@section('css')
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    {{ Form::pgHeader($role->addressee,'Roles',route('admin.roles.index')) }}
    
    <div class="box box-primary"> 
      <div class="box-header">
        <div class="row">
          <div class="col-md-6"><h4>{{$role->display_name}} <small>{{$role->description}}</small></h4></div>
          <div class="col-md-6">
            <a href="{{route('admin.roles.edit',$role->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit role</a>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <select class="input-roles" multiple>
              @foreach ($role->permissions as $pp)
                <option selected value="{{$pp->id}}">{{$pp->display_name}}</option>
              @endforeach
              @foreach ($permissions as $perm)
                <option value="{{$perm->id}}">{{$perm->display_name}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
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