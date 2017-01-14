<head>
    <meta charset="UTF-8">
    <title>Welcome to the UMC worship music site</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta id="token" name="token" value="{{csrf_token()}}">
    <!-- Bootstrap 3.3.6 -->
    <link href="{{ asset('vendor/adminlte/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <script src="{{ asset('vendor/adminlte/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    <script src="{{ asset('vendor/adminlte/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/bishopm/mediaelement/lib/mediaelement.js')}}"></script>
    <script src="{{ asset('vendor/bishopm/mediaelement/lib/mediaelementplayer.js')}}"></script>
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('vendor/bishopm/mediaelement/skin/mediaelementplayer.css')}}">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/adminlte/dist/css/skins/skin-blue.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/bishopm/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/print.css') }}" media="print">
    @yield('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
