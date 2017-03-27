@extends('connexion::templates.webpage')

@section('css')
    <link rel="stylesheet" href="{{asset('/vendor/bishopm/css/bootstrap-datepicker.min.css')}}">
@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
	<div class="row top30">
	  @if ((Auth::check()) and (Auth::user()->individual->household_id==$special->household_id))
	  	<h4>Anniversary <small>{{$special->household->addressee}}</small></h4>
	  	@include('connexion::shared.errors')
	    {!! Form::open(['route' => array('admin.specialdays.update',$special->household_id), 'method' => 'put']) !!}

		{{ Form::bsText('anniversarydate','Anniversary date','Anniversary date',$special->anniversarydate) }}
		{{ Form::bsText('details','Details','Details',$special->details) }}
		{{ Form::bsSelect('anniversarytype','Anniversary Type',array('baptism','death','wedding'),$special->anniversarytype) }}
		{{ Form::bsHidden('household_id',$special->household_id) }}
		{{ Form::bsHidden('id',$special->id) }}
	    {{ Form::pgButtons('Update',route('mydetails')) }}
	    {!! Form::close() !!}
	  @else
		<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to edit this anniversary</p>
	  @endif
	</div>
</div>
@endsection

@section('js')
<script src="{{asset('/vendor/bishopm/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    $(function () {
        $("#anniversarydate").datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
@endsection