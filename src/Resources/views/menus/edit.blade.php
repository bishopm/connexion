@extends('connexion::templates.backend')

@section('css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{url('/')}}/public/vendor/bishopm/css/nestable.css">
@stop

@section('content_header')
    {{ Form::pgHeader('Edit menu','Menus',route('admin.menus.index')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.menus.update',$menu->id), 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-6">
            <a href="{{route('admin.menuitems.create',$menu->id)}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add a new menu item</a><br><br>
            <div class="dd">
                {!!$menuitems!!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary"> 
                <div class="box-body">
                    @include('connexion::menus.partials.edit-fields')
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
    <script src="{{url('/')}}/public/vendor/bishopm/js/jquery.nestable.js" type="text/javascript"></script>
    <script>
    $( document ).ready(function() {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
        });
        $('.dd').nestable();
        $('.dd').on('change', function() {
            var data = $('.dd').nestable('serialize');
            $.ajax({
                type: 'POST',
                url: '{{route('admin.menuitems.reorder',1)}}',
                data: {'menu': JSON.stringify(data), '_token': '{{ csrf_token() }}'},
                dataType: 'json',
                success: function(data) {

                },
                error:function (xhr, ajaxOptions, thrownError){
                }
            });
        });
        $('.jsDeleteMenuItem').on('click', function(e) {
            var self = $(this),
                menuItemId = self.data('item-id');
            $.ajax({
                type: 'DELETE',
                url: "{{url('/')}}/admin/menus/{{$menu->id}}/menuitems/" + menuItemId,
                data: {
                    _token: '{{ csrf_token() }}',
                     menuitem: menuItemId
                },
                success: function(data) {
                    if (! data.errors) {
                        var elem = self.closest('li');
                        elem.fadeOut()
                        setTimeout(function(){
                            elem.remove()
                        }, 300);
                    }
                }
            });
        });
    });
    </script>
@stop