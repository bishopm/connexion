@extends('base::worship.page')

@section('css')
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
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
                <ul id="songlist" class="list-unstyled">
                </ul>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <form method="POST" action="{{url('/')}}/sets/sendemail">
                        {{ csrf_field() }}
                        <div class="col-sm-12">
                            <textarea name="message" class="form-control" rows="20">Email message</textarea>
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
    <script src="{{ asset('vendor/bishopm/js/jquery.nestable.js') }}"></script>
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
            $('#newitem').on('change', function() {
                if (this.value!=''){
                  var newsong=this.value;
                  var $select = $('#newitem').selectize(); 
                  var selectSizeControl = $select[0].selectize; 
                  selectSizeControl.removeOption( selectSizeControl.getValue());
                  $.ajax(
                  { url: "{{url('/')}}/admin/worship/addsetitem/{{$set->id}}/" + newsong,
                    success: 
                      function(dat,ni) {
                        $('#songlist').append('<li class="list-group-item"> ' + dat.title + '<a href="#"><span class="pull-right fa fa-times"></span></a></li>');
                      }.bind(this)
                  });
                }
                $('#newitem').focus();
            });
        });
    </script>
@stop
