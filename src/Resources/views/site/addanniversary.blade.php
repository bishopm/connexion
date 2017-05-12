@extends('connexion::templates.frontend')

@section('css')
    <link rel="stylesheet" href="{{asset('/public/vendor/bishopm/css/bootstrap-datepicker.min.css')}}">
@stop

@section('content')
<div class="container">
	<div class="row top30">
	  @if (Auth::check())
	  	<h4>Add an anniversary <small>{{$household->addressee}}</small></h4>
	  	@include('connexion::shared.errors')
	    {!! Form::open(['route' => array('admin.specialdays.store',$household->id), 'method' => 'post']) !!}

		{{ Form::bsText('anniversarydate','Anniversary date','Anniversary date') }}
		{{ Form::bsText('details','Details','Details') }}
		{{ Form::bsSelect('anniversarytype','Anniversary Type',array('baptism','death','wedding'),'wedding') }}
		{{ Form::bsHidden('household_id',$household->id) }}
	    {{ Form::pgButtons('OK',route('mydetails')) }}
	    {!! Form::close() !!}
	  @else
		<p><a class="btn btn-primary btn-flat" href="{{url('/')}}/register">Register</a> or <button class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-login" data-action-target="{{ route('login') }}"><i class="fa fa-login"></i>Login</button> to add an anniversary</p>
	  @endif
	</div>
</div>
@endsection

@section('js')
<script src="{{asset('/public/vendor/bishopm/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    $(function () {
        $("#anniversarydate").datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
@endsection