<h4>Comments</h4>
@if (Auth::user()->can('edit-comment'))
	<div id="allcomments">
		@foreach ($comments as $comment)
			<div class="row top5">
				<div class="col-xs-2 col-sm-1">
					<a href="{{route('webuser',$comment->commented->individual->slug)}}">
					@if (count($comment->commented->individual->getMedia('image')))
		                <img width="50px" class="img-responsive img-circle img-thumbnail" src="{{$comment->commented->individual->getMedia('image')->first()->getUrl()}}">
		            @else
		                <img width="50px" class="img-responsive img-circle img-thumbnail" src="{{asset('vendor/bishopm/images/profile.png')}}">
		            @endif
		            </a>
				</div>
				<div class="col-xs-10 col-sm-11" style="font-size: 80%">
					<a href="{{route('webuser',$comment->commented->individual->slug)}}">{{$comment->commented->individual->firstname}} {{$comment->commented->individual->surname}}</a>: {{$comment->comment}}
					@if (isset($comment->rate))
						<div class="ratingro" data-rate-value={{$comment->rate}}></div>
					@endif
					<div><i>{{date("j M",strtotime($comment->created_at))}}</i></div>
				</div>
			</div>
		@endforeach 
		{{$comments->links()}}
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-3 col-sm-1">
			<a href="{{route('webuser',Auth::user()->individual->slug)}}">
			@if (count(Auth::user()->individual->getMedia('image')))
                <img width="50px" class="img-responsive img-circle img-thumbnail" src="{{Auth::user()->individual->getMedia('image')->first()->getUrl()}}">
            @else
                <img width="50px" class="img-responsive img-circle img-thumbnail" src="{{asset('vendor/bishopm/images/profile.png')}}">
            @endif
            </a>
		</div>
		<div class="col-xs-6 col-sm-9">
			@if (isset($rating))
				<textarea rows="5" name="newcomment" id="newcomment" class="form-control" placeholder="If you've done the course, leave a comment and star rating to help others considering doing it."></textarea>
			@elseif (count($comments))
				<textarea rows="5" name="newcomment" id="newcomment" class="form-control" placeholder="Join the conversation :)"></textarea>
			@else
				<textarea rows="5" name="newcomment" id="newcomment" class="form-control" placeholder="Make a comment / ask a question"></textarea>
			@endif
		</div>
		<div class="col-xs-3 col-sm-2">
			@if (isset($rating))
				<div class="rating"></div>
			@endif
			<a id="publishButton" class="btn btn-primary">Publish</a>
		</div>
	</div>
@else
	<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to see comments or add your own</p>
@endif