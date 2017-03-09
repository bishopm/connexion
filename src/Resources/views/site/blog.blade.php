@extends('connexion::templates.webpage')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  <div class="col-md-9">
		  <h3>{{$blog->title}} <small>{{$blog->individual->firstname}} {{$blog->individual->surname}}</small></h3>
		  @foreach ($blog->tags as $tag)
		  	<a class="btn btn-primary" href="{{url('/')}}/subject/{{$tag->name}}">{{$tag->name}}</a></b>&nbsp;
		  @endforeach
		  <br>
		  {{$blog->body}}
	  </div>
	  <div class="col-md-3">
	  	<h3>Other tags</h3>
	  </div>
	  <div class="row">
	    <div class="col-md-12">
		  @if ((isset($currentUser)) and ($currentUser->hasPermissionTo('edit-comment')))
		  	@include('connexion::shared.comments', ['entity' => $blog])
		  @else
		  	<h4><a href="{{url('/')}}/register">Register</a> and <a href="{{url('/')}}/login">login</a> to comment</h4>
		  @endif
	    </div>
	  </div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
      });
      $('#publishButton').on('click',function(){
      	user={{$currentUser->id or 0}};
      	if (user){
      		newcom='<div class="row"><div class="col-md-1"><img width="100%" src="{{$currentUser->individual->getMedia("image")->first()->getUrl()}}"><br><i>{{date("j M")}}</i></div><div class="col-md-11"><a href="{{route("admin.users.show",$currentUser->id)}}">{{$currentUser->individual->firstname}} {{$currentUser->individual->surname}}</a>: ' + $('textarea#newcomment').val() + '</div></div>';
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
@endsection