@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{url('/')}}/vendor/bishopm/css/nestable.css">
@stop

@section('content_header')
    {{ Form::pgHeader('Edit menu','Menus',route('admin.menus.index')) }}
@stop

@section('content')
    {!! Form::open(['route' => array('admin.menus.update',$menu->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-6">
            <a href="{{route('admin.menuitems.create',$menu->id)}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add a new menu item</a><br><br>
            <div class="dd">
                <ol class="dd-list">
                    @foreach ($menuitems as $menuitem)
                        <li class="dd-item" data-id="$menuitem->id">
                            <div class="dd-handle">{{$menuitem->title}}</div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('base::menus.partials.edit-fields')
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Update',route('admin.menus.index')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{url('/')}}/vendor/bishopm/js/jquery.nestable.js" type="text/javascript"></script>
    <script>$('.dd').nestable();</script>
@stop