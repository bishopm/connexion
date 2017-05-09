@extends('connexion::templates.webpage_jqold')

@section('css')
<link href="{{ asset('/public/vendor/bishopm/css/filterizr.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="container">
  	<h1>Meet the {{$setting['site_abbreviation']}} community</h1>
    @if (Auth::check())
    <ul class="nav nav-gallery filters">
        <input type="text" class="filtr-search" name="filtr-search" data-search>    
        <li class="filtr-button filtr" data-filter="all">All</li>
        <li class="filtr-button filtr" data-filter="999999">Staff</li>
        <li class="filtr-button filtr" data-filter="1">07h00</li>
        <li class="filtr-button filtr" data-filter="2">08h30</li>
        <li class="filtr-button filtr" data-filter="3">10h00</li>
    </ul>
    <div class="row">
        <div class="filtr-container">
            @foreach ($users as $user)
                @if (isset($user->individual))
                <div class="col-xs-4 col-sm-3 col-md-2 filtr-item" data-category="{{$user->status}}" data-sort="{{$user->individual->slug}}">
                    <a href="{{url('/')}}/users/{{$user->individual->slug}}">
                        @if ($user->individual->image)
                            <img class="img-responsive img-circle img-thumbnail" src="{{url('/')}}/public/storage/individuals/{{$user->individual->id}}/{{$user->individual->image}}">
                        @else
                            <img class="img-responsive img-circle img-thumbnail" src="{{asset('public/vendor/bishopm/images/profile.png')}}">
                        @endif
                        <p class="text-center item-desc">{{$user->individual->firstname}} {{$user->individual->surname}}</p>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @else 
        <p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to see other {{$setting['site_abbreviation']}} user profiles</p>
    @endif	  	
</div>
@endsection

@section('js')
<script src="{{ asset('public/vendor/bishopm/js/jquery.filterizr.js') }}" type="text/javascript"></script>
<script language="javascript">
    $(function() {
        //Initialize filterizr with default options
        $('.filtr-container').filterizr();
    });
</script>
@stop