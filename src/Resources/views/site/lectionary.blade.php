@extends('connexion::templates.frontend')

@section('title','Lectionary readings')

@section('content')
<div class="container">
    <div class="col-md-12">
        <h3>{{$title}}</h3>
        <ul class="nav nav-tabs" role="tablist">
            @foreach ($readings as $reading)
                @if ($loop->first)
                    <li role="presentation" class="active"><a href="#{{$loop->index}}" role="tab" data-toggle="tab">{{$reading['reading']}}</a></li>
                @else
                    <li role="presentation"><a href="#{{$loop->index}}" role="tab" data-toggle="tab">{{$reading['reading']}}</a></li>
                @endif
            @endforeach
        </ul>
        <div class="tab-content top20">
            @foreach ($readings as $reading)
                @if ($loop->first)
                    <div role="tabpanel" class="tab-pane active" id="{{$loop->index}}">
                @else
                    <div role="tabpanel" class="tab-pane" id="{{$loop->index}}">
                @endif
                {!!$reading['text']!!}
                <small class="label label-default">{!!$reading['copyright']!!}</small>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection