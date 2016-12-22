<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide carousel-fade">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    @foreach ($slides as $counter)
      @if ($loop->first)
        <li data-target="#myCarousel" data-slide-to="{{$loop->index}}" class="active"></li>
      @else
        <li data-target="#myCarousel" data-slide-to="{{$loop->index}}"></li>
      @endif
    @endforeach
  </ol>
  <div class="carousel-inner">
    @foreach ($slides as $slide)
      @if ($loop->first)
        <div class="item active">
      @else
        <div class="item">
      @endif
      <img src="{{$slide->getMedia('image')->first()->getUrl()}}" class="img-responsive">
      <div class="container">
        <div class="carousel-caption">
          <h1>{{$slide->title}}</h1>
          <p></p>
          <p>{{$slide->description}}</p>
        </div>
      </div>
      </div>
    @endforeach
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