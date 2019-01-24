@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/vendor/bishopm/icheck/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.css" rel="stylesheet">
@stop

@section('content_header')
    {{ Form::pgHeader('Send a message','Messages',route('admin.messages.create')) }}
@stop

@section('content')
    @include('connexion::shared.errors')
    {!! Form::open(['route' => array('admin.messages.store'), 'method' => 'post', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="msg-type" class="control-label">Message type</label>
                                <div>
                                    <input type="radio" class="msgtype" name="msgtype" value="email" checked> Email
                                    &nbsp;<input type="radio" class="msgtype" name="msgtype" value="app"> App message
                                    @if (isset($credits))
                                        &nbsp;<input type="radio" class="msgtype" name="msgtype" value="sms"> SMS ({{$credits}} credits available)
                                    @else
                                        &nbsp;<b>SMS not available - <a href="{{ route('admin.settings.index') }}">click here to change settings</a></b>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="groups" class="control-label">Groups</label>
                                <select multiple name="groups[]" id="groups">
                                @foreach ($groups as $grp)
                                    @if (($group>0) and ($group==$grp->id))
                                        <option selected value="{{$grp->id}}">{{$grp->groupname}}</option>
                                    @else
                                        <option value="{{$grp->id}}">{{$grp->groupname}}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="emailrow1">
                        <div class="col-md-6">
                            {{ Form::bsText('sender','Sender','Sender',Auth::user()->email) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::bsText('subject','Subject','Subject','Message from ' . $setting['site_abbreviation']) }}
                        </div>                                                
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="msgtype" class="control-label">Group recipients</label>
                                <div>
                                    <p><input type="radio" class="grouprec" name="grouprec" value="allmembers" checked> All group members
                                    &nbsp;<input type="radio" class="grouprec" name="grouprec" value="leadersonly"> Leaders only</p>
                                    @can('edit-backend')
                                        <p><input type="radio" class="grouprec" name="grouprec" value="allchurchmembers"> All church members
                                        &nbsp;<input type="radio" class="grouprec" name="grouprec" value="everyone"> Entire database</p>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="individuals" class="control-label">Extra individuals</label>
                                <select multiple name="individuals[]" id="individuals">
                                @foreach ($individuals as $individual)
                                    <option value="{{$individual->id}}">{{$individual->fullname}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>                      
                        <div class="col-md-12" id="attachrow">
                            {!! Form::label('attachment','Attachment', array('class'=>'control-label')) !!}
                        	{!! Form::file('attachment', null, array('class'=>'form-control')) !!}
                        </div>
                    </div>
                    <div class="row" id="emailrow2">
                        <div class="col-md-12">
                            {{ Form::bsTextarea('emailmessage','Message','Message') }}
                        </div>
                    </div>
                    <div class="row hidden" id="smsrow1">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="smsmessage" class="control-label">SMS Message (</label><span id="chars">130 characters left</span>)
                                <textarea placeholder="SMS message" class="form-control" id="smsmessage" name="smsmessage" maxlength="130"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {{Form::pgButtons('Send message',route('admin.messages.create')) }}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('js')
    <script src="{{ asset('/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/bishopm/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.10/summernote.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#groups').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0
            });            
            $('#individuals').selectize({
              plugins: ['remove_button'],
              openOnFocus: 0
            });            
            $('#emailmessage').summernote();
            $('.msgtype').on('ifChecked', function(event){
                if (event.target.value=='sms'){
                    $('#emailrow1').addClass('hidden');
                    $('#emailrow2').addClass('hidden');              
                    $('#attachrow').addClass('hidden');
                    $('#smsrow1').removeClass('hidden');
                } else if (event.target.value=='email') {
                    $('#emailrow1').removeClass('hidden');
                    $('#emailrow2').removeClass('hidden');
                    $('#smsrow1').addClass('hidden');
                    $('#attachrow').removeClass('hidden');
                } else if (event.target.value=='app') {
                    $('#emailrow1').addClass('hidden');
                    $('#emailrow2').removeClass('hidden');                 
                    $('#smsrow1').addClass('hidden');
                    $('#attachrow').addClass('hidden');
                }
            });
            $('.msgtype').iCheck({
              radioClass: 'iradio_minimal-blue'
            });
            $('.grouprec').iCheck({
              radioClass: 'iradio_minimal-blue'
            });
            var maxLength = 130;
            $('#smsmessage').keyup(function() {
              var length = $(this).val().length;
              var length = maxLength-length;
              if (length!==1) {
                  $('#chars').text(length + ' characters left');
              } else {
                  $('#chars').text(length + ' character left');
              }
            });
        });
    </script>
@stop