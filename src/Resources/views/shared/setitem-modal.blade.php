<div class="modal fade modal-primary" id="modal-setitem" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="delete-confirmation-title">Add a set item</h3>
            </div>
            <div class="modal-body">
                <form action="{{url('/')}}/admin/worship/addorderitem" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-xs-12">
                            {{ Form::bsHidden('set_id',$set->id) }}
                            {{ Form::bsSelect('itemtype','',array('reading','welcome','sermon','other')) }}
                            {{ Form::bsText('description','','Text to appear in order of service') }}
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-flat">OK</button> <a class="btn btn-default btn-flat" href="{{url('/')}}/users/" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>