@extends('connexion::templates.backend')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('public/vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    <link rel="stylesheet"
          href="{{ asset('public/vendor/bishopm/css/app.css')}} ">
    <meta id="token" name="token" value="{{csrf_token()}}">
    @stack('css')
    @yield('css')
    <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />          
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini fixed')

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">

                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li class="hidden-xs">
                            <a href="{{url('/')}}/admin/worship"><span class="fa fa-home"></span>&nbsp;Worship home</a>
                        </li>
                        <li class="hidden-xs">
                            <a href="{{url('/')}}/admin/worship/songs/create"><span class="fa fa-plus-square"></span>&nbsp;New song</a>
                        </li>
                        <li class="hidden-xs">
                            <a href="{{url('/')}}/admin/worship/sets"><span class="fa fa-list-ol"></span>&nbsp;Sets</a>
                        </li>
                        <li class="hidden-xs">
                            <a href="{{url('/')}}/admin/worship/chords"><span class="fa fa-music"></span>&nbsp;Chords</a>
                        </li>
                        <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar" id="sidebar">
                <ul class="sidebar-menu">
                    <li class="visible-xs"><a href="{{url('/')}}/admin/worship"><i class='fa fa-home'></i> Home </a></li>
                    <li class="visible-xs"><a href="{{url('/')}}/admin/worship/chords"><i class='fa fa-music'></i> Guitar Chords </a></li>
                    <li class="visible-xs"><a href="{{url('/')}}/admin/worship/songs/create"><i class='fa fa-plus-square'></i> Add a new song </a></li>
                    <li class="visible-xs"><a href="{{url('/')}}/admin/worship/sets"><i class='fa fa-list-ol'></i> Worship sets </a></li>
                    <form action="{{url('/')}}/admin/worship/search" id="searchform" method="get" v-on:submit.prevent="onSubmit" class="sidebar-form" role="form">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <input v-model="q" v-on:keyup="searchMe" autocomplete=off autofocus="autofocus" type="text" name="q" id="searchbox" class="form-control" placeholder="Search by lyrics..."/>
                                <span class="input-group-btn">
                                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="checkbox" v-on:change="searchMe" name="hymns" value="hymns" id="hymns">
                            <label style="color:white;" v-on:change="searchMe" for="hymns">Hymns</label>
                        </div>
                        <div class="col-xs-6">                        
                            <input type="checkbox" v-on:change="searchMe" name="songs" value="songs" id="songs">
                            <label style="color:white;" for="songs">Songs</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="checkbox" v-on:change="searchMe" name="liturgy" value="liturgy" id="liturgy">
                            <label style="color:white;" for="liturgy">Liturgy</label>
                        </div>
                        <div class="col-xs-6">
                            <input type="checkbox" v-on:change="searchMe" name="archive" value="archive" id="archive">
                            <label style="color:white;" for="archive">Archive</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <select multiple name="searchtags[]" id="songsearch">
                                @foreach ($tags as $tag)
                                    <option value="{{$tag->name}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </form>
                    <li class="songtitles" v-for="song in songs">
                        <a v-bind:class="song.musictype" :href="song.url">@{{ song.title }}</a>
                    </li>
                </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('public/vendor/adminlte/dist/js/app.min.js') }}"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        $('#songsearch').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0,
              maxOptions: 5,
              placeholder: 'Search by tag...',
              dropdownParent: null
        });
        $('#songs').prop('checked', true);
        $('#hymns').prop('checked', true);
    });
    </script>
    @yield('js')
@stop
