@extends('adminlte::page')

@section('css')
  <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content_header')
  {{ Form::pgHeader('Add a sermon to this series','All series',route('admin.series.index')) }}
@stop

@section('content')  
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary"> 
          <div class="box-header">
            <div class="row">
              <div class="col-md-6"><h4>{{$series->series}}</h4></div>
              <div class="col-md-6"><a href="{{route('admin.series.edit',$series->id)}}" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Edit series</a> <a href="{{route('admin.sermons.create',$series->id)}}" style="margin-right:7px;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add a sermon</a></div>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4"><img class="img-responsive" src="{{$series->getMedia('image')->first()->getUrl()}}"></div>
              <div class="col-md-8">
                @forelse ($series->sermons as $sermon)
                  <div class="row">
                    <div class="col-md-3">
                      <a href="{{route('admin.sermons.edit',array($series->id,$sermon->id))}}">{{$sermon->sermon}}</a>
                    </div>
                    <div class="col-md-3">
                      {{$sermon->servicedate}}
                    </div>                  
                    <div class="col-md-3">
                      {{$sermon->readings}}
                    </div>  
                    <div class="col-md-3">
                      {{$sermon->person_id}}
                    </div>
                  </div>
                @empty
                  No sermons have been added to this series yet
                @endforelse
              </div>
            </div>
            <hr>
            <div class="row">     
              <div class="col-md-6">
                  {{$series->description}}
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