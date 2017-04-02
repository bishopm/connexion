@extends('connexion::templates.webpage')

@section('css')
  <meta id="token" name="token" value="{{ csrf_token() }}" />
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row">
	  @if (Auth::check())
		  <div class="col-md-12">
			  <h3>My details <small>{{$household->addressee}}</small></h3>
		  </div>
		  <div class="col-md-6">
		  	<div><b>Residential address</b>&nbsp;&nbsp;<a href="{{url('/')}}/my-details/householdedit" class="btn btn-primary btn-xs">Edit my household</a></div>
			<div>{{$household->addr1}}</div>
			<div>{{$household->addr2}}</div>
			<div>{{$household->addr3}}</div>
			<div><b>Postal address</b></div>
			<div>{{$household->post1}}</div>
			<div>{{$household->post2}}</div>
			<div>{{$household->post3}}</div>
			<div><b>Home phone: </b>{{$household->homephone}}</div>
			<div><b>SMS'es go to: </b>{{$household->cellmember}}</div>
			<div class="top20"><b>Anniversaries</b>&nbsp;&nbsp;<a href="{{url('/')}}/my-details/add-anniversary" class="btn btn-primary btn-xs">Add an anniversary</a></div>
			@foreach ($household->specialdays as $ann)
				<div>{{date("d M Y",strtotime($ann->anniversarydate))}} - {{$ann->details}} ({{$ann->anniversarytype}}) <a class="btn btn-default btn-xs" href="{{url('/')}}/my-details/edit-anniversary/{{$ann->id}}">Edit</a></div>
			@endforeach
		  </div>
		  <div class="col-md-6">
			  <ul class="nav nav-tabs" role="tablist">
			  	@foreach ($household->individuals as $tabname)
			  		@if ($loop->first)
				    	<li role="presentation" class="active">
				    @else
						<li role="presentation">
				    @endif
				    <a href="#{{$tabname->id}}" aria-controls="home" role="tab" data-toggle="tab">{{$tabname->firstname}}</a></li>
			    @endforeach
			    <li><a href="{{url('/')}}/my-details/add-individual" title="Add new individual to this household">+</a></li>
			  </ul>
			  <!-- Tab panes -->
			  <div class="tab-content">
			  	@foreach ($household->individuals as $indiv)
			  		<div role="tabpanel" 
			  			@if ($loop->first)
				    		class="tab-pane active" id="{{$indiv->id}}">
				    	@else
							class="tab-pane" id="{{$indiv->id}}">
				    	@endif
				    	<div class="row top20">
			    			<div class="col-md-12"><b>{{$indiv->title}} {{$indiv->firstname}} {{$indiv->surname}}</b>&nbsp;&nbsp;<a href="{{url('/')}}/my-details/edit/{{$indiv->slug}}" class="btn btn-primary btn-xs">Edit {{$indiv->firstname}}</a></div>
			    			<div class="col-md-12"><i class="fa fa-fw fa-mobile"></i> {{$indiv->cellphone}}</div>
			    			<div class="col-md-12"><i class="fa fa-fw fa-envelope-o"></i> {{$indiv->email}}</div>
			    			<div class="col-md-12"><i class="fa fa-fw fa-birthday-cake"></i> 
				    			@if ($indiv->birthdate)
				    				{{date("d M Y",strtotime($indiv->birthdate))}}
				    			@else
				    				No birthday on record
				    			@endif
				    		</div>
			    			<div class="col-md-12"><i class="fa fa-fw fa-gift"></i>
			    				@if ($indiv->giving)
			    					Planned giver (click <b>here</b> to see your number and recorded payments)
			    				@else
			    					No planned giving number <button data-toggle="modal" data-target="#modal-giving">Allocate me a PG number</button>
			    				@endif
			    			</div>
			    			@if (isset($indiv->service_id))
				    			<div class="col-md-12"><b>Service: </b> {{$indiv->service->society->society}} {{$indiv->service->servicetime}}</div>
				    		@endif
			    		</div>
			    		<div class="row top20">
			    			<div class="col-md-12">
				    			<b>Groups: </b>
				    			@foreach ($indiv->groups as $group)
				    				@if ($group->publish)
						    			<a href="{{url('/')}}/group/{{$group->slug}}">{{$group->groupname}}</a>
						    		@else
						    			{{$group->groupname}}
						    		@endif
					    			@if (!$loop->last)
					    				,
					    			@elseif (count($indiv->groups))
					    				.
					    			@endif
					    		@endforeach
					    	</div>
			    		</div>
			    	</div>
			    @endforeach
			  </div>
		  </div>
	  @else 
	  	<h3>My details</h3>
        <p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to see your profile details</p>
      @endif
	</div>
</div>
@include('connexion::shared.giving-modal')
@endsection

@section('js')
<script type="text/javascript">
	@include('connexion::shared.giving-modal-script')
</script>
<script type="text/javascript">
	$.ajaxSetup({
	  	headers: {
	    	'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
	  	}
	});
	$('.addPg').on('click',function(e){
		var activeTab = $(".tab-content").find(".active");
		var id = activeTab.attr('id');
        $.ajax({
            type : 'GET',
            url : '{{url("/")}}/admin/households/{{$household->id}}/individuals/' + id + '/giving/' + e.target.innerText,
            success: function(){
            	$('#modal-giving').modal('hide');
            	location.reload();
            }
        });
      });
</script>
@stop