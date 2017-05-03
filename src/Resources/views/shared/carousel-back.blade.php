<!-- Carousel
================================================== -->
<div id="myCarousel" class="carousel slide carousel-fade hidden-xs">
  <div class="carousel-inner">
    @foreach ($slides as $slide)
      @if ($loop->first)
        <div class="item active">
      @else
        <div class="item">
      @endif
      <img src="{{url('/')}}/public/storage/slides/{{$slide->image}}" style="width:100%">
      <div class="container">
        <div class="carousel-caption">
        </div>
      </div>
      </div>
    @endforeach
  </div>
  <!-- Controls -->
</div>
<!-- /.carousel -->