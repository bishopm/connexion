@if (!isset($reply))
	{{ Form::bsText('title','Title','Title') }}
@else
	@if (isset($post))
		<div class="well">
			<div class="row">
				<div class="col-xs-2">
					<small><a href="{{url('/')}}/users/{{$post->user->individual->slug}}">{{$post->user->individual->firstname}} {{$post->user->individual->surname}}</a><br>{{date("d M Y H:i", strtotime($post->created_at))}}</small>
				</div>
				<div class="col-xs-10">{!! $post->body !!}</div>
			</div>
		@foreach ($replies as $reply)
			<div class="row top20">
				<div class="col-xs-2">
					<small><a href="{{url('/')}}/users/{{$post->user->individual->slug}}">{{$reply->user->individual->firstname}} {{$reply->user->individual->surname}}</a><br>{{date("d M Y H:i", strtotime($reply->created_at))}}</small>
				</div>
				<div class="col-xs-10">{!! $reply->body !!}</div>
			</div>
		@endforeach
		</div>
		{{ Form::bsHidden('thread',$post->id)}}
	@endif
@endif
{{ Form::bsTextarea('body','Body','Body') }}
{{ Form::bsHidden('user_id',Auth::user()->id)}}