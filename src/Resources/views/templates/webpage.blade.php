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
      <div class="navbar navbar-default navbar-static-top" style="padding-left:10px; padding-right:10px;">
        <div class="navbar-header">
        <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="navbar-brand" href="#">{!!$setting['site_logo']!!}</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="http://www.bootply.com" target="ext">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://www.facebook.com/umhlalimethodist" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="http://www.twitter.com/umhlalichurch" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a href="http://www.youtube.com/umhlalimethodist" target="_blank"><i class="fa fa-youtube"></i></a></li>
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