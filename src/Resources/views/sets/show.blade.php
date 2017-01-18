@extends('base::worship.page')

@section('css')
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{url('/')}}/vendor/bishopm/css/nestable.css">
@stop

@section('content')
<div id="setpage" class="box box-default">
    <div class="box-header">
        @include('base::shared.errors')
        <h3 class="box-title">{{$set->servicedate}} <span class="small">{{$set->service->society->society}} {{$set->service->servicetime}}</span></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <select class="selectize" id="newitem">
                    <option></option>
                    @foreach ($songs as $song)
                        <option value="{{$song->id}}">{{$song->title}}</option>
                    @endforeach
                </select>
                <div class="dd">
                    <ol id="songlist" class="dd-list">

                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <form method="POST" action="{{url('/')}}/sets/sendemail">
                        {{ csrf_field() }}
                        <div class="col-sm-12">
                            <textarea id="message" class="form-control" rows="20"></textarea>
                        </div>
                        <div class="col-sm-12">&nbsp;</div>
                        <div class="col-sm-12">
                            <button href="#" class="btn btn-default" type="submit">Send email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
    @include('base::worship.partials.scripts')
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bishopm/js/jquery.nestable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
        });
        $( document ).ready(function() {
            $('#newitem').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 30
            });
            $.ajax(
              { url: "{{url('/')}}/admin/worship/getitems/{{$set->id}}",
                success: 
                  function(data) {
                    data.forEach(function(seti, index) {
                        $('#songlist').append('<li id="li' + seti.id + '" class="dd-item" data-id="' + seti.id + '"><div class="btn-group" role="group" aria-label="Action buttons" style="display: inline"><a class="dellink btn btn-sm btn-danger" href="#" id="' + seti.id + '" style="float:right; height:30px; valign:vertical;"><i class="fa fa-times"></i></a></div><div class="dd-handle">' + seti.title + '</div></li>');
                    });
                    $('.dd').nestable().on('change', function() { 
                        var data = $('.dd').nestable('serialize');
                        $.ajax({
                            type: 'POST',
                            url: "{{url('/')}}/admin/worship/reorderset/{{$set->id}}",
                            data: {'items': JSON.stringify(data), '_token': '{{ csrf_token() }}'},
                            dataType: 'json',
                            success: setTimeout(updatemessage, 1000),
                            error:function (xhr, ajaxOptions, thrownError){
                            }
                        });
                    });
                    setTimeout(updatemessage, 1000);
                  }.bind(this)
              });
            $('#newitem').on('change', function() {
                if (this.value!=''){
                  var newsong=this.value;
                  var $select = $('#newitem').selectize(); 
                  var selectSizeControl = $select[0].selectize; 
                  selectSizeControl.removeOption( selectSizeControl.getValue());
                  $('.selectize-input').css({'height':'35px'});
                  $.ajax(
                  { url: "{{url('/')}}/admin/worship/addsetitem/{{$set->id}}/" + newsong,
                    success: 
                      function(dat,ni) {
                        $('#songlist').append('<li id="li' + dat.id + '" class="dd-item" data-id="' + dat.id + '"><div class="btn-group" role="group" aria-label="Action buttons" style="display: inline"><a class="dellink btn btn-sm btn-danger" href="#" id="' + dat.id + '" style="float:right; height:30px; valign:vertical;"><i class="fa fa-times"></i></a></div><div class="dd-handle">' + dat.title + '</div></li>');
                      }.bind(this)
                  });
                }
                setTimeout(updatemessage, 1000);
                $('#newitem').focus();
            });
        });
        $(document).on('click', '.dellink', function () {
            $.ajax({ url: "{{url('/')}}/admin/worship/deletesetitem/" + this.id });
            $('#li'+this.id).remove();
            setTimeout(updatemessage, 1000);
        });
        function updatemessage () {
            $.ajax({ url: "{{url('/')}}/admin/worship/getmessage/{{$set->id}}",
                success: 
                  function(dat) {
                    $("textarea#message").text(dat);
                  }.bind(this)
            });
        };
    </script>
@stop

<div class=\"btn-group\" role=\"group\" aria-label=\"Action buttons\" style=\"display: inline\"></div>