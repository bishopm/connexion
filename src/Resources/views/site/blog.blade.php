@extends('connexion::templates.webpage')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9">
		  <h3>{{$blog->title}} <small><a href="{{url('/')}}/people/{{$blog->individual->slug}}">{{$blog->individual->firstname}} {{$blog->individual->surname}}</a>&nbsp;
		  @foreach ($blog->tags as $tag)
		  	<a class="label label-primary" href="{{url('/')}}/subject/{{$tag->name}}">{{$tag->name}}</a></b>&nbsp;
		  @endforeach
		  </small></h3>
		  {!!$blog->body!!}
	  </div>
	  <div class="col-md-3">
	  	<h3>Other tags</h3>
	  </div>
	  <div class="row">
	    <div class="col-md-12">
		   	@include('connexion::shared.comments', ['entity' => $blog])
	    </div>
	  </div>
	</div>
</div>
@endsection

@section('js')
@if (isset($currentUser))
<script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
      });
      $('#publishButton').on('click',function(){
      	user={{$currentUser->id or 0}};
      	if (user){
          newcom='<div class="row"><div class="col-xs-2 col-sm-1"><img width="50px" src="{{$currentUser->individual->getMedia("image")->first()->getUrl()}}"></div><div class="col-xs-10 col-sm-11" style="font-size: 80%"><a href="{{route("admin.users.show",$currentUser->id)}}">{{$currentUser->individual->firstname}} {{$currentUser->individual->surname}}</a>: ' + $('textarea#newcomment').val() + '<div><i>{{date("j M")}}</i></div></div></div>';
      	}
        $.ajax({
            type : 'POST',
            url : '{{route('admin.blogs.addcomment',$blog->id)}}',
            data : {'newcomment':$('textarea#newcomment').val(),'user':user},
            success: function(){
            	$(newcom).appendTo('#allcomments');
            }
        });
      });
</script>
@endif
@endsection