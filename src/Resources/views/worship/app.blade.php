<!DOCTYPE html>
<html>
  @include('base::worship.partials.htmlheader')
  <body class="skin-blue sidebar-mini">
  @include('base::worship.partials.scripts')
  <div class="wrapper">
      @include('base::worship.partials.mainheader')
      @include('base::worship.partials.sidebar')
      <div class="content-wrapper">
          <section class="content">
              @yield('content')
          </section>
      </div>
      @yield('js')
  </div>
  </body>
</html>
