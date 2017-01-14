<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/admin') }}" title="Back to admin home page" class="logo hidden-xs">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{!!$setting['site_logo_mini']!!}</span>
        <!-- logo for regular state and mobile devices -->
        {!!$setting['site_logo']!!}
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="visible-xs sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav navbar-right">
                <li class="smalllogo">
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
            </ul>
        </div>
    </nav>
</header>
