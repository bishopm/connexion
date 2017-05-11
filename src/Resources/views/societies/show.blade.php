@extends('adminlte::page')

@section('css')
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
  {{ Form::pgHeader('Add a service to this society','All societies',route('admin.societies.index')) }}
@stop

@section('content')
@include('connexion::shared.errors')   
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary"> 
          <div class="box-header">
            <div class="row">
              <div class="col-md-6"><h4>{{$society->society}}</h4></div>
              <div class="col-md-6"><a href="{{route('admin.societies.edit',$society->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit society</a> <a href="{{route('admin.services.create',$society->id)}}" style="margin-right:7px;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add a service</a></div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
               <div id="map_canvas" class="top10" style="height:250px;"></div>
              </div>
              <div class="col-md-6">
                <h4>Sunday services</h4>
                <ul class="list-unstyled">
                  @forelse ($society->services as $service)
                    <li><a href="{{route('admin.services.edit',array($society->id,$service->id))}}">{{$service->servicetime}} ({{$service->language}})</a></li>
                  @empty
                    No services have been added to this society yet
                  @endforelse
                </ul>
              </div>              
            </div>
          </div>
        </div>
      </div>
    </div>
@stop

@section('js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{$setting['google_api']}}"></script>
<script src="{{url('/')}}/public/vendor/bishopm/js/mapsinglepoint.js" type="text/javascript"></script>
<script type="text/javascript">
(function ($) {
  jQuery(window).on('load', function() {
    google.maps.event.addDomListener(window, 'load', initialize(11,{{$society->latitude}},{{$society->longitude}}));
  });
})(jQuery);
</script>
@endsection