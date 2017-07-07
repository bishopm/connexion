<div class="modal fade modal-danger" id="modal-delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="delete-confirmation-title">Are you sure?</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'delete']) !!}
                <div class="form-group">
                    <label for="msg-type" class="control-label">Are you sure you want to remove this individual?</label>
                    <div>
                        <div class="row">
                            <div class="col-xs-6">
                                <input type="radio" class="deltype" name="deltype" value="archive" checked> Archive this member's details
                            </div>
                            <div class="col-xs-6">
                                <input type="radio" class="deltype" name="deltype" value="delete"> Completely remove this member
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-xs-6">
                                <input type="radio" class="deltype" name="deltype" value="death"> This member has died
                            </div>
                            <div class="col-xs-6">
                                <input type="text" id="deathdate" class="form-control" name="deathdate" placeholder="Date of death">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-outline btn-flat"><i class="fa fa-trash"></i>Delete</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>