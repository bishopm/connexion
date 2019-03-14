<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{$setting['site_description']}}"/>
    <meta name="keywords" content="{{$setting['searchengine_keywords']}}" />
    <meta property="og:image" content="@yield('page_image')" />
    <meta property="og:description" content="@yield('page_description')" />
    <meta property="og:title" content="@yield('title')" />
    <link rel="stylesheet" href="{{ asset('/vendor/bishopm/css/bootstrap.css')}}">
    <style media="screen" type="text/css">
    :root {
      --primary: {{$setting['colour_primary']}};
      --secondary: {{$setting['colour_secondary']}};
      --tertiary: {{$setting['colour_tertiary']}};
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('css')
    <title>@yield('title_prefix', $setting['site_name']) | @yield('title')</title>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="{{url('/')}}">{!!$setting['site_logo']!!}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        {!!$webmenu!!}
        <ul class="navbar-nav">
          @if(Auth::check())
            <li class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                @if (Auth::user()->individual)
                  {{Auth::user()->individual->firstname}} 
                @else
                  {{Auth::user()->name}} 
                @endif
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                @if (Auth::user()->can('view-backend'))
                  <a class="dropdown-item" href="{{url('/')}}/admin"><i class="fa fa-fw fa-cogs"></i> Backend</a>
                @endif
                @if (Auth::user()->individual)
                  <a class="dropdown-item" href="{{url('/')}}/users/{{Auth::user()->individual->slug}}"><i class="fa fa-fw fa-info-circle"></i> My user profile</a>
                @endif
                <a class="dropdown-item" href="{{url('/')}}/my-church"><i class="fa fa-fw fa-group"></i> My {{$setting['site_abbreviation'] or 'church'}}</a>
                @if (Auth::user()->individual)
                  <a class="dropdown-item" href="{{url('/')}}/my-details"><i class="fa fa-fw fa-user"></i> My details</a>
                  <a class="dropdown-item" href="{{url('/')}}/forum"><i class="fa fa-fw fa-comments-o"></i> User forum</a>
                @endif
                @if (Auth::user()->can('view-worship'))
                  <a class="dropdown-item" href="{{url('/')}}/admin/worship"><i class="fa fa-fw fa-music"></i> Worship</a>
                @endif
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                <form id="logout-form" action="{{url('/')}}/logout" method="POST" style="display: none;"><input type="hidden" name="_token" value="{{csrf_token()}}"></form>
              </div>
            </li>
          @else
            <li class="nav-item">
              <a class="dropdown-item" href="#" title="User login" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login / Register</a>
            </li>
          @endif
        </ul>
      </div>
    </nav>

    @if ((isset($slideshow)) and ($slideshow->slideshow=="back"))
      @include('connexion::shared.carousel-back')
    @elseif ((isset($slideshow)) and ($slideshow->slideshow=="front"))
      @include('connexion::shared.errors')
      @include('connexion::shared.carousel-front')
    @endif
    @yield('content')
    <div class="top30"></div>
    @include('connexion::shared.login-modal') 
</body>
<!-- FOOTER -->
<footer class="footer">
  <div class="container text-center">
    <div class="row mt-3">
      @foreach ($webfooter as $kk=>$wf)
        <div class="col-sm-3"><h4>{{$kk}}</h4>
          <ul class="list-unstyled">
            @foreach ($wf as $wi)
                <li>{!!$wi!!}</li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
    <div class="row">
      <div class="col-sm-12">
        <i class="fa fa-phone"></i> {{$setting['church_phone']}} | <i class="fa fa-envelope-o"></i> {{ HTML::mailto($setting['church_email']) }}
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        {{$setting['church_address']}} |
         <a href="{{$setting['facebook_page']}}" title="Facebook page" target="_blank"><i class="fa fa-facebook"></i></a>&nbsp;
        <a href="{{$setting['twitter_profile']}}" title="Twitter profile" target="_blank"><i class="fa fa-twitter"></i></a>&nbsp;
        <a href="{{$setting['youtube_page']}}" title="Youtube channel" target="_blank"><i class="fa fa-youtube"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        Service times: {{$setting['service_times'] ?? ''}}
      </div>
    </div>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{asset('/vendor/bishopm/js/popper.min.js')}}"></script>
<script src="{{asset('/vendor/bishopm/js/bootstrap.min.js')}}"></script>
<script>
@include('connexion::shared.login-modal-script')
</script>
@yield('js')
@include('connexion::shared.analytics')
</html>