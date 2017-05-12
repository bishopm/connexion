@extends('connexion::templates.frontend')

@section('title','Sign up for a course: ' . $course->title)

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
  <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')  
    <div class="container">
      <h3>{{$course->title}}
      </h3>
        <div class="row">
          <div class="col-md-3"><img class="img-responsive" width="250px" src="{{url('/')}}/public/storage/courses/{{$course->image}}"></div>
          <div class="col-md-3">
          {!!$course->description!!}
          </div>
          <div class="col-md-6">
              <h4>{{$course->group->groupname}}</h4>
              @if (Auth::check())
                The co-ordinator of this course or event is {{$leader->firstname}} {{$leader->surname}}. You can contact the ofice or {{$leader->firstname}} directly if you need more information. Or just go ahead and sign up and {{$leader->firstname}} will be notified and we'll get in touch with you if needed.
                <label class="top20" for="individual_id">Which members of your household would like to sign up?</label>
                {!! Form::open(['route' => array('admin.groups.signup',$group->id), 'method' => 'post']) !!}
                <select class="selectize" name="individual_id[]" multiple>
                  @foreach (Auth::user()->individual->household->individuals as $indiv)
                    <option value="{{$indiv->id}}">{{$indiv->firstname}} {{$indiv->surname}}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-flat">Sign up</button> <a class="btn btn-danger btn-flat" href="{{route('webresource',$course->slug)}}"><i class="fa fa-times"></i> Cancel</a>
                {!! Form::close() !!}
              @else
                <p class="top20"><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to sign up automatically, or send us an {{ HTML::mailto($setting['church_email'],'email') }}.</p>
              @endif
          </div> 
          <hr>
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
              openOnFocus: 0
            }); 
        });
    </script>
@stop