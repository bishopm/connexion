<div id="pastoralpartial" class="box box-default">
  <div class="box-header">
    <h4>Pastoral contact <button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#pastoralModal"><i class="fa fa-plus"></i></button></h4>
  </div>
  <div class="modal fade" id="pastoralModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Add pastoral contact entry</h4>
        </div>
        <div class="modal-body">
          <form id="paddform">
            <input type="hidden" name="household_id" value="{{$household->id}}">
            <table class="table" id="paddtable">
              <tr><th class="colspan-md-6">Date</th>
                <td class="colspan-md-6">
                  <input id="pastoraldate" name="pastoraldate">
                </td>
              </tr>
              <tr>
                <th class="colspan-md-6">Type</th>
                <td class="colspan-md-6">
                  <select name="actiontype">
                    <option>phone</option>
                    <option>message</option>
                    <option>visit</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th class="colspan-md-6">Details</th>
                <td class="colspan-md-6">
                  <input name="details">
                </td>
              </tr>
              <tr>
                <th class="colspan-md-6">Pastor</th>
                <td class="colspan-md-6">
                  <select name="individual_id">
                    @foreach (json_decode($pastors) as $id=>$pastor)
                      <option value="{{$id}}">{{$pastor}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
            </table>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id="psavebutton" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <div class="box-body">
    @if (count($household->pastoral))
      <div class="alert-container"></div>
      <table id="pastoraltable">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Type</th>
            <th>Details</th>
            <th>Pastor</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($household->pastoral as $pastoral)
            <tr>
              <td>{{$pastoral->id}}</td>
              <td>{{$pastoral->pastoraldate}}</td>
              <td>{{$pastoral->actiontype}}</td>
              <td>{{$pastoral->details}}</td>
              <td>{{$allpastors[$pastoral->individual_id]}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      No pastoral contact recorded
    @endif
  </div>
</div>
{{$household->pastoral}}
