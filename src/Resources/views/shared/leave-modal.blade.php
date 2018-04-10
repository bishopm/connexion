<div class="modal fade modal-primary" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="delete-confirmation-title">Leave</h3>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.staff.addleave')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <label>Leave type</label>
                            <select class="form-control" name="leavetype">
                                <option>annual</option>
                                <option>family</option>
                                <option>sabbatical</option>
                                <option>sick</option>
                                <option>study</option>                                
                                <option>unknown</option>                                                                
                                <option>unpaid</option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="input-group date" data-provide="datepicker" id="datepicker">
                                    <input type="text" class="form-control" name="leavedate">
                                    <div class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-flat">Save</button> <a class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

