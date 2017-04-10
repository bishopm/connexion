<div class="modal fade modal-primary" id="modal-message" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="delete-confirmation-title">Send a message to {{$user->individual->firstname}}</h3>
            </div>
            <div class="modal-body">
                <form action="{{url('/')}}/users/{{$user->id}}/message" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-xs-12">
                            {{ Form::bsTextarea('message','Message','Message') }}
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-flat">Send</button> <a class="btn btn-default btn-flat" href="{{url('/')}}/users/{{$user->individual->slug}}"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>