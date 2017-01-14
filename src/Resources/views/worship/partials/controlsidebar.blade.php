<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-admin-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">{{auth()->user()->name}}</h3>
            <div class="container">
              <ul class='control-sidebar-menu'>
                  <li>
                      {{auth()->user()->email}}
                  </li>
                  <br>
                  <p><a href="{{ url('/auth/logout') }}" class="btn btn-default">Sign out</a></p>
              </ul><!-- /.control-sidebar-menu -->
            </div>
        </div><!-- /.tab-pane -->
        <div class="tab-pane" id="control-sidebar-admin-tab">
            <h3 class="control-sidebar-heading">Admin panel</h3>
            <div class="container">
              <ul class='control-sidebar-menu'>
                    <p><a href="{{ url('/users') }}">View users</a></p>
              </ul><!-- /.control-sidebar-menu -->
            </div>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
