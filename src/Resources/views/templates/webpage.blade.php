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
      <div class="navbar navbar-default navbar-static-top" style="padding-left:20px; padding-right:20px;">
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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$currentUser->name}} <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="admin">Admin section</a></li>
                  <li><a href="#">Worship</a></li>
                  <li role="separator" class="divider"></li>
                  <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    <form id="logout-form" action="http://localhost/mjb/public/logout" method="POST" style="display: none;"><input type="hidden" name="_token" value="{{csrf_token()}}"></form>
                  </li>
                </ul>
              </li>
            @else
              <li><a href="{{url('/')}}/admin" title="Login to backend"><i class="fa fa-lock"></i></a></li>
            @endif
          </ul>
        </div>
      </div>
    </div><!-- /navbar wrapper -->
    @yield('content')
</body>
<!-- FOOTER -->
<footer>
  <p class="pull-right"><a href="#">Back to top</a></p>
  <p>This Bootstrap layout is compliments of Bootply. · <a href="http://www.bootply.com/62603">Edit on Bootply.com</a></p>
</footer>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{asset('vendor/bishopm/js/bootstrap.min.js')}}"></script>
@yield('js')
</html>