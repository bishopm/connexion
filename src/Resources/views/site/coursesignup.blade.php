@extends('connexion::templates.webpage')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop

@section('content')  
    <div class="container">
      <h3>{{$course->title}}
      </h3>
        <div class="row">
          <div class="col-md-3"><img class="img-responsive" width="250px" src="{{$course->getMedia('image')->first()->getUrl()}}"></div>
          <div class="col-md-3">
          {!!$course->description!!}
          </div>
          <div class="col-md-6">
              {{$course->group->description}}
              @if (Auth::check())
                <p class="top20">Which members of your household want to sign up?</p>
                <ul class="top20">
                @foreach (Auth::user()->individual->household->individuals as $indiv)
                  <li>{{$indiv->firstname}} {{$indiv->surname}}</li>
                @endforeach
                </ul>
              @else
                <p class="top20"><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to sign up automatically, or send us an {{ HTML::mailto($setting['church_email'],'email') }}.</p>
              @endif
          </div> 
          <hr>
        </div>
      </div>
    </div>
@stop