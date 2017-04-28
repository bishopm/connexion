@if(count($errors))
    <div class="alert alert-danger"><h4>Error!</h4>
    	<div class="row">
    		<ul>
	        @foreach ($errors->all() as $error)
	            <li>{{ $error }}</li>
	        @endforeach
	        </ul>
	    </div>
    </div>
@endif
@if (Session::has('success'))
  <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>
      <i class="fa fa-check-circle fa-lg fa-fw"></i> Success!  
    </strong>
    {{ Session::get('success') }}
  </div>
@endif
@if (Session::has('notice'))
  <div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>
      <i class="fa fa-info-circle fa-lg fa-fw"></i> Please note: 
    </strong>
    {{ Session::get('notice') }}
  </div>
@endif
@if (isset($errormessage))
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>
      <i class="fa fa-info-circle fa-lg fa-fw"></i> Error!
    </strong>
    {{ $errormessage }}
  </div>
@endif