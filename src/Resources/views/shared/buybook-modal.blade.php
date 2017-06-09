<div class="modal fade modal-primary" id="modal-message" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="delete-confirmation-title">Buy book</h3>
                <ul>
                    <li>Unfortunately we can't courier. Books can be collected from our church office, which is open on weekday mornings.</li>
                    <li>Payment can be made by Zapper, EFT or cash on collection.</li>
                    <li>Click 'Order' below to email us your order details and we'll be in touch asap. Or call the office if you prefer :)</li>
                </ul>
            </div>
            <div class="modal-body">
                <form id="orderbookform" name="orderbookform" action="{{url('/')}}/admin/books/placeorder" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="errormsg" class="alert alert-danger" style="display:none;"></div>
                            @if (Auth::check())
                                {{ Form::bsText('name','Name','Please enter your name',Auth::user()->individual->firstname . " " . Auth::user()->individual->surname)}}
                                {{ Form::bsText('email','Email','Please supply your email address', Auth::user()->individual->email)}}
                            @else
                                {{ Form::bsText('name','Name','Please enter your name')}}
                                {{ Form::bsText('email','Email','Please supply your email address')}}
                            @endif
                            {{ Form::bsText('title','Title','Title',"Book Order: " . $fulltitle)}}
                            {{ Form::bsTextarea('message','Message (add additional details if necessary)','Message',$messagetxt) }}
                        </div>
                        <div class="col-xs-12">
                            <button id="submitbutton" type="button" class="btn btn-primary btn-flat">Order</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>