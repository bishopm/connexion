<div id="myCarousel" class="carousel slide carousel-fade hidden-xs-up mb-3" data-ride="carousel">
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
        </div>
      </div>
      </div>
    @endforeach
  </div>
  <!-- Controls -->
</div>
<!-- /.carousel --> 