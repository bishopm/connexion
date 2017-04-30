@if ((Auth::check()) and (isset(Auth::user()->individual)))
  <?php
  if (Auth::user()->individual->image){
    $imgsrc=url('/') . "/storage/individuals/" . Auth::user()->individual->id . "/" . Auth::user()->individual->image;
  } else {
    $imgsrc=asset('vendor/bishopm/images/profile.png');
  }?>
  <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
      });
      $('#publishButton').on('click',function(){
      	user={{Auth::user()->id or 0}};
      	if (user){
          newcom='<div class="row top5"><div class="col-xs-2 col-sm-1"><img class="img-responsive img-circle img-thumbnail" width="50px" src="{{$imgsrc}}"></div><div class="col-xs-10 col-sm-11" style="font-size: 80%"><a href="{{route("admin.users.show",Auth::user()->id)}}">{{Auth::user()->individual->firstname}} {{Auth::user()->individual->surname}}</a>: ' + $('textarea#newcomment').val() + '<div><i>{{date("j M")}}</i></div></div></div>';
      	}
        $.ajax({
            type : 'POST',
            url : '{{$url}}',
            data : {'newcomment':$('textarea#newcomment').val(),'user':user,'rating':$(".rating").rate("getValue")},
            success: function(){
            	$(newcom).appendTo('#allcomments');
            }
        });
      });
</script>
@endif