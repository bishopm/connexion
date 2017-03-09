<h4>Comments</h4>
<div id="allcomments">
	@foreach ($entity->comments as $comment)
		<div class="row">
			<div class="col-xs-2 col-sm-1">
				<img width="100%" src="{{$comment->commented->individual->getMedia('image')->first()->getUrl()}}"><br><i>{{date("j M",strtotime($comment->created_at))}}</i>
			</div>
			<div class="col-xs-10 col-sm-11" style="font-size: 80%">
				<a href="{{route('admin.users.show',$comment->commented_id)}}">{{$comment->commented->individual->firstname}} {{$comment->commented->individual->surname}}</a>: {{$comment->comment}}
			</div>
		</div>
	@endforeach
</div>
<hr>
<div class="row">
	<div class="col-xs-3 col-sm-2">
		<img width="100%" src="{{$currentUser->individual->getMedia('image')->first()->getUrl()}}">
	</div>
	<div class="col-xs-8 col-sm-9">
		@if (count($entity->comments))
			<textarea rows="5" name="newcomment" id="newcomment" class="form-control" placeholder="Join the conversation :)"></textarea>
		@else
			<textarea rows="5" name="newcomment" id="newcomment" class="form-control" placeholder="Make a comment / ask a question"></textarea>
		@endif
	</div>
	<div class="col-xs-1 col-sm-1">
		<a id="publishButton" class="btn btn-primary">Publish</a>
	</div>
</div>