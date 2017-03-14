@extends('connexion::templates.webpage')

@section('css')

@stop

@section('content')
<img class="img-responsive" src="{{ asset('vendor/bishopm/images/webpageheader.png') }}">
<div class="container">
  	<h1>Meet the {{$setting['site_abbreviation']}} community</h1>
    <ul>
       <input type="text" class="filtr-search" name="filtr-search" data-search>    
       <li class="btn btn-primary" data-filter="all"> All </li>
       <li class="btn btn-primary" data-filter="1"> Staff </li>
    </ul>
    <div class="row">
        <div class="filtr-container">
            @foreach ($users as $user)
                <div class="col-xs-4 col-sm-3 col-md-2 filtr-item" data-category="1" data-sort="Staff">
                    <a href="{{url('/')}}/users/{{$user->individual->slug}}"><img class="img-responsive img-circle img-thumbnail" src="{{$user->individual->getMedia('image')->first()->getUrl()}}">
                    <p class="text-center item-desc">{{$user->individual->firstname}} {{$user->individual->surname}}</p></a>
                </div>
            @endforeach
        </div>
    </div>	  	
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/bishopm/js/jquery.filterizr.js') }}" type="text/javascript"></script>
<script language="javascript">
    $(function() {
        //Initialize filterizr with default options
        $('.filtr-container').filterizr();
    });
</script>
@stop