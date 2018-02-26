<div id="myCarousel" class="carousel slide carousel-fade hidden-xs-up mb-3" data-ride="carousel">
  @if (count($slideshow->slides)>1)
    <ol class="carousel-indicators">
      @foreach ($slideshow->slides as $counter)
        @if ($loop->first)
          <li data-target="#myCarousel" data-slide-to="{{$loop->index}}" class="active"></li>
        @else
          <li data-target="#myCarousel" data-slide-to="{{$loop->index}}"></li>
        @endif
      @endforeach
    </ol>
  @endif
  <div class="carousel-inner">
    @foreach ($slideshow->slides as $slide)
      @if ($loop->first)
        <div class="carousel-item active">
      @else
        <div class="carousel-item">
      @endif
      <img src="{{url('/')}}/storage/slides/{{$slide->image}}" class="d-block w-100">
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
  @if (count($slideshow->slides)>1)
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a> 
  @endif
</div>