@extends('connexion::templates.frontend')

@section('title','Sign up for an event: ' . $event->groupname)

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')  
    <div class="container">
      <div class="row">
        <div class="col-md-6">
        <h3>{{$event->groupname}} <small>{{date("d M Y H:i",$event->eventdatetime)}}</small></h3>
        @if ($leader->user)
          Co-ordinator: <a href="{{url('/')}}/users/{{$leader->slug}}">{{$leader->firstname}} {{$leader->surname}}</a>.
        @else
          Co-ordinator: {{$leader->firstname}} {{$leader->surname}}.
        @endif
        <p>{!!$event->description!!}</p>
        </div>
        <div class="col-md-6">
            @if (Auth::check())
              <label class="top20" for="individual_id">Which members of your household would like to sign up?</label>
              {!! Form::open(['route' => array('admin.events.signup',$event->id), 'method' => 'post']) !!}
              <select class="selectize" name="individual_id[]" multiple>
                @foreach (Auth::user()->individual->household->individuals as $indiv)
                  @if (in_array($indiv->id, $people))
                    <option selected value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
                  @else
                    <option value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
                  @endif
                @endforeach
              </select>
              <button type="submit" class="btn btn-primary btn-flat">OK</button> <a class="btn btn-danger btn-flat" href="{{route('webresource',$event->slug)}}"><i class="fa fa-times"></i> Cancel</a>
              {!! Form::close() !!}
            @else
              <p class="top20"><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to sign up automatically, or send us an {{ HTML::mailto($setting['church_email'],'email') }}.</p>
            @endif
        </div> 
      </div>
      </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('public/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.selectize').selectize({
              plugins: ['remove_button'],
              openOnFocus: 1
            }); 
        });
    </script>
@stop