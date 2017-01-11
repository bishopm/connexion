@extends('adminlte::page')

@section('content_header')
  {{ Form::pgHeader('Add a rating to this resource','All resources',route('admin.resources.index')) }}
@stop

@section('content')  
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary"> 
          <div class="box-header">
            <div class="row">
              <div class="col-md-6"><h4>{{$resource->title}}</h4></div>
              <div class="col-md-6"><a href="{{route('admin.resources.edit',$resource->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit resource</a> <a href="{{route('admin.ratings.create',$resource->id)}}" style="margin-right:7px;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add a rating</a></div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4"><img class="img-responsive" src="{{$resource->getMedia('image')->first()->getUrl()}}"></div>
              <div class="col-md-8">
                @forelse ($resource->ratings as $rating)
                  <div class="row">
                    <div class="col-md-4">
                      <a href="{{route('admin.ratings.edit',array($resource->id,$rating->id))}}">{{$rating->rating}}</a>
                    </div>
                    <div class="col-md-4">
                      {{$rating->comment}}
                    </div>                  
                    <div class="col-md-4">
                      {{$rating->group_id}}
                    </div>  
                  </div>
                @empty
                  No ratings have been added to this resource yet
                @endforelse
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
    </div>
@stop