{{ Form::bsText('name','Username','Username',$user->name) }}
{{ Form::bsText('email','Email','Email',$user->email) }}
{{ Form::bsText('bio','Brief bio','Brief bio',$user->bio) }}
{{ Form::bsText('slack_username','Slack username','Slack username',$user->slack_username) }}
{{ Form::bsSelect('notification_channel','Notification Channel',array('Email','Slack'),$user->notification_channel) }}
{{ Form::bsSelect('allow_messages','Allow direct messages',array('Yes','No'),$user->allow_messages) }}
<div class="form-group">
    <label for="individual_id" class="control-label">Linked to which individual (if any)</label>
    <select name="individual_id" class="input-individual">
    <option value="0"></option>
    @foreach ($individuals as $individual)
        @if ($individual->id==$user->individual_id)
            <option selected value="{{$individual->id}}">{{$individual->firstname}} {{$individual->surname}}</option>
        @else
            <option value="{{$individual->id}}">{{$individual->firstname}} {{$individual->surname}}</option>
        @endif
    @endforeach
    </select>
</div>
<div class="form-group">
    <label for="role_id" class="control-label">Roles</label>
    <select name="role_id[]" class="input-role" multiple>
    @foreach ($roles as $role)
        @if (in_array($role->id,$userroles))
            <option selected value="{{$role->id}}">{{$role->name}}</option>
        @else
            <option value="{{$role->id}}">{{$role->name}}</option>
        @endif
    @endforeach
    </select>
</div>