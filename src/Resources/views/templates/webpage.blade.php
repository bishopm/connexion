<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', $setting['site_name'])</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('vendor/bishopm/themes/' . $setting['website_theme'] . '.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    @yield('css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="navbar-wrapper">
      <div class="navbar navbar-inverse navbar-static-top" style="padding-left:20px; padding-right:20px;">
        <div class="navbar-header">
        <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="navbar-brand" href="{{url('/')}}">{!!$setting['site_logo']!!}</a>
        </div>
        <div class="navbar-collapse collapse">
          {!!$webmenu!!}
          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://www.facebook.com/umhlalimethodist" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="http://www.twitter.com/umhlalichurch" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a href="http://www.youtube.com/umhlalimethodist" target="_blank"><i class="fa fa-youtube"></i></a></li>
            @if(isset($currentUser))
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$currentUser->individual->firstname}} <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  @can('edit-backend'))
                    <li><a href="{{url('/')}}/admin"><i class="fa fa-fw fa-cogs"></i> Backend</a></li>
                  @endcan
                  <li><a href="{{url('/')}}/users/{{$currentUser->individual->slug}}"><i class="fa fa-fw fa-info-circle"></i> My user profile</a></li>
                  <li><a href="{{url('/')}}/my-church"><i class="fa fa-fw fa-group"></i> My {{$setting['site_abbreviation']}}</a></li>
                  <li><a href="{{url('/')}}/my-details"><i class="fa fa-fw fa-user"></i> My details</a></li>
                  @can('worship-edit'))
                    <li><a href="{{url('/')}}/admin/worship"><i class="fa fa-fw fa-music"></i> Worship</a></li>
                  @endcan
                  <li role="separator" class="divider"></li>
                  <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    <form id="logout-form" action="http://localhost/mjb/public/logout" method="POST" style="display: none;"><input type="hidden" name="_token" value="{{csrf_token()}}"></form>
                  </li>
                </ul>
              </li>
            @else
              <li><a href="#" title="User login" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-sign-in"></i></a></li>
            @endif
          </ul>
        </div>
      </div>
    </div><!-- /navbar wrapper -->
    @yield('content')
    @include('connexion::shared.login-modal') 
</body>
<!-- FOOTER -->
<footer class="footer">
  <div class="text-center top30">5 Burnedale Place, Umhlali| <i class="fa fa-phone"></i> 032 947 0173 | <i class="fa fa-envelope-o"></i> {{ HTML::mailto('info@umc.org.za') }}</li></div>
</footer>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{asset('vendor/bishopm/js/bootstrap.min.js')}}"></script>
<script>
@include('connexion::shared.login-modal-script')
</script>
@yield('js')
</html>