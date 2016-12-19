@extends('base::templates.webpage')

@section('htmlheader_title')
    Dashboard
@endsection

@section('content')
<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="item active">
      <img src="http://placehold.it/1500X500" class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
          <h1>Bootstrap 3 Carousel Layout</h1>
          <p></p>
          <p><a class="btn btn-lg btn-primary" href="http://getbootstrap.com">Learn More</a>
        </p>
        </div>
      </div>
    </div>
    <div class="item">
      <img src="http://placehold.it/1500X500" class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
          <h1>Changes to the Grid</h1>
          <p>Bootstrap 3 still features a 12-column grid, but many of the CSS class names have completely changed.</p>
          <p><a class="btn btn-large btn-primary" href="#">Learn more</a></p>
        </div>
      </div>
    </div>
    <div class="item">
      <img src="http://placehold.it/1500X500" class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
          <h1>Percentage-based sizing</h1>
          <p>With "mobile-first" there is now only one percentage-based grid.</p>
          <p><a class="btn btn-large btn-primary" href="#">Browse gallery</a></p>
        </div>
      </div>
    </div>
  </div>
  <!-- Controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="icon-prev"></span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="icon-next"></span>
  </a>  
</div>
<!-- /.carousel -->

<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container top30">
  <!-- Three columns of text below the carousel -->
  <div class="row">
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/blog.png')}}">
      <h4>From our Blog</h4>
      <ul class="list-unstyled">
          <li>Blog post 1</li>
          <li>Blog post 2</li>
          <li>Blog post 3</li>
          <li>Blog post 4</li>
          <li>Blog post 5</li>
      </ul>
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/preaching.png')}}">
      <h4>Last Sunday</h4>
      <p>Image and mp3 player here</p>
    </div>
    <div class="col-md-4 text-center">
      <img src="{{asset('vendor/bishopm/images/contact.png')}}">
      <h4>Contact us</h4>
      <ul class="list-unstyled">
          <li><a target="_blank" href="https://www.google.com/maps/dir/''/umhlali+methodist+church/@-29.4819617,31.2221114,19z/data=!4m8!4m7!1m0!1m5!1m1!1s0x1ef7150f285b2b6d:0x5ca4f6f9b530a1e2!2m2!1d31.222661!2d-29.48198">5 Burnedale Place, Umhlali</a></li>      
          <li>032 947 0173 (weekday mornings)</li>
          <li><b>Sunday services:</b> 07h00 | 08h30 | 1000</li>
          <li><b>Children and youth:</b> Sundays 08h30</li>
      </ul>
    </div>
  </div><!-- /.row -->
</div>
@endsection