@extends('connexion::templates.backend')

@section('css')
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
  {{ Form::pgHeader('Add a slide to this slideshow','All slideshows',route('admin.slideshows.index')) }}
@stop

@section('content')  
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary"> 
          <div class="box-header">
            <div class="row">
              <div class="col-md-6"><h4>{{ucfirst($slideshow->slideshow)}}</h4></div>
              <div class="col-md-6"><a href="{{route('admin.slideshows.edit',$slideshow->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit slideshow</a> <a href="{{route('admin.slides.create',$slideshow->id)}}" style="margin-right:7px;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add a slide</a></div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <b>Title</b>
                  </div>
                  <div class="col-md-3">
                    <b>Description</b>
                  </div>                  
                  <div class="col-md-3">
                    <b>Order</b>
                  </div>  
                  <div class="col-md-3">
                    <b>Active</b>
                  </div>
                </div>
                @forelse ($slideshow->slides as $slide)
                  <div class="row">
                    <div class="col-md-3">
                      <a href="{{route('admin.slides.edit',array($slideshow->id,$slide->id))}}">{{$slide->title}}</a>
                    </div>
                    <div class="col-md-3">
                      {{$slide->description}}
                    </div>                  
                    <div class="col-md-3">
                      {{$slide->rankorder}}
                    </div>  
                    <div class="col-md-3">
                      @if ($slide->active)
                        Yes
                      @else
                        No
                      @endif
                    </div>
                  </div>
                @empty
                  No slides have been added to this slideshow yet
                @endforelse
              </div>
            </div>
            <hr>
            <div class="row">     
              <div class="col-md-12">
                  {{$slideshow->description}}
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@stop