@extends('connexion::templates.webpage')

@section('css')
  <link href="{{ asset('/public/vendor/bishopm/css/isotope.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="container">
  	<h1>Meet the {{$setting['site_abbreviation']}} community</h1>
    @if (Auth::check())
    <div class="button-group filter-button-group">
        <button data-filter="*" class="btn btn-primary">All</button>
            @foreach ($services as $service)
                <button class="btn btn-primary" data-filter=".{{$service->servicetime}}">{{$service->servicetime}}</button>
            @endforeach
        <button class="btn btn-primary" data-filter=".staff">Staff</button>
    </div>
    <div class="row">
        <div class="grid top20">
            @foreach ($users as $user)
                @if (isset($user->individual))
                <div class="col-xs-4 col-sm-3 col-md-2 element-item {{$user->status}}">
                    <a href="{{url('/')}}/users/{{$user->individual->slug}}">
                        @if ($user->individual->image)
                            <img class="img-responsive img-circle" src="{{url('/')}}/public/storage/individuals/{{$user->individual->id}}/{{$user->individual->image}}">
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
<script src="{{ asset('public/vendor/bishopm/js/isotope.min.js') }}" type="text/javascript"></script>
<script language="javascript">
    $(window).on('load', function() {
        // init Isotope
        var $grid = $('.grid').isotope({
          // options
        });
        // filter items on button click
        $('.filter-button-group').on( 'click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });
        });
    });
</script>
@stop