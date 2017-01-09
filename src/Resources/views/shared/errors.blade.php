@if(count($errors))
    <div class="alert alert-error"><h4>Error - record has not been saved</h4>
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