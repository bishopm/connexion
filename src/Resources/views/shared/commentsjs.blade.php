@if (isset($currentUser))
  <?php
  if (count($currentUser->individual->getMedia('image'))){
    $imgsrc=$currentUser->individual->getMedia("image")->first()->getUrl();
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
      	user={{$currentUser->id or 0}};
      	if (user){
          newcom='<div class="row"><div class="col-xs-2 col-sm-1"><img width="50px" src="{{$imgsrc}}"></div><div class="col-xs-10 col-sm-11" style="font-size: 80%"><a href="{{route("admin.users.show",$currentUser->id)}}">{{$currentUser->individual->firstname}} {{$currentUser->individual->surname}}</a>: ' + $('textarea#newcomment').val() + '<div><i>{{date("j M")}}</i></div></div></div>';
      	}
        $.ajax({
            type : 'POST',
            url : '{{$url}}',
            data : {'newcomment':$('textarea#newcomment').val(),'user':user},
            success: function(){
            	$(newcom).appendTo('#allcomments');
            }
        });
      });
</script>
@endif