{{ Form::bsText('name','Username','Username') }}
{{ Form::bsText('email','Email','Email') }}
{{ Form::bsPassword('password','Password','Password') }}
{{ Form::bsText('bio','Brief bio','Brief bio') }}
{{ Form::bsText('slack_username','Slack username','Slack username') }}
{{ Form::bsSelect('notification_channel','Notification Channel',array('Email','Slack')) }}
{{ Form::bsSelect('allow_messages','Allow direct messages',array('Yes','No')) }}
<div class="form-group">
    <label for="individual_id" class="control-label">Linked to which individual (if any)</label>
    <select name="individual_id" class="input-individual">
        <option value="0"></option>
        @foreach ($individuals as $individual)
        <option value="{{$individual->id}}">{{$individual->firstname}} {{$individual->surname}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="role_id" class="control-label">Roles</label>
    <select name="role_id[]" class="input-role" multiple>
        @foreach ($roles as $role)
            <option value="{{$role->id}}">{{$role->name}}</option>
        @endforeach
    </select>
</div>