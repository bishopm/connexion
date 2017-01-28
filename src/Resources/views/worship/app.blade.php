<!DOCTYPE html>
<html>
  @include('connexion::worship.partials.htmlheader')
  <body class="skin-blue sidebar-mini">
  @include('connexion::worship.partials.scripts')
  <div class="wrapper">
      @include('connexion::worship.partials.mainheader')
      @include('connexion::worship.partials.sidebar')
      <div class="content-wrapper">
          <section class="content">
              @yield('content')
          </section>
      </div>
      @yield('js')
  </div>
  </body>
</html>
