<div class="box-body">
  {!! Form::normalInput('addressee', 'Addressee', $errors, $household) !!}
  {!! Form::normalInput('addr1', 'Residential address', $errors, $household) !!}
  <div class='form-group {{($errors->has('addr2') ? ' has-error' : '')}}'><input class="form-control" placeholder="Residential address 2" name="addr2" value="{{$household->addr2}}" type="text" id="addr2"></div>
  <div class='form-group {{($errors->has('addr3') ? ' has-error' : '')}}'><input class="form-control" placeholder="Residential address 3" name="addr3" value="{{$household->addr3}}" type="text" id="addr2"></div>
  {!! Form::normalInput('post1', 'Postal address', $errors, $household) !!}
  <div class='form-group {{($errors->has('post2') ? ' has-error' : '')}}'><input class="form-control" placeholder="Postal address 2" name="post2" value="{{$household->post2}}" type="text" id="post2"></div>
  <div class='form-group {{($errors->has('post3') ? ' has-error' : '')}}'><input class="form-control" placeholder="Postal address 3" name="post3" value="{{$household->post3}}" type="text" id="post3"></div>
  {!! Form::normalInput('householdcell', 'Household cellphone', $errors, $household) !!}
  {!! Form::normalInput('homephone', 'Home telephone', $errors, $household) !!}
</div>
