@extends('connexion::templates.backend')

@section('css')
    <link href="{{ asset('/public/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/vendor/bishopm/icheck/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/vendor/bishopm/summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
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
                                    &nbsp;<input type="radio" class="msgtype" name="msgtype" value="sms"> SMS
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="groups" class="control-label">Groups</label>
                                <select multiple name="groups[]" id="groups">
                                @foreach ($groups as $group)
                                    <option value="{{$group->id}}">{{$group->groupname}}</option>
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
                            {{ Form::bsText('subject','Subject','Subject') }}
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
                    </div>
                    <div class="row" id="emailrow2">
                        <div class="col-md-12">
                            {{ Form::bsTextarea('emailmessage','Message','Message') }}
                        </div>
                    </div>
                    <div class="row hidden" id="smsrow1">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="smsmessage" class="control-label">SMS Message (</label><span id="chars">100 characters left</span>)
                                <textarea placeholder="SMS message" class="form-control" id="smsmessage" name="smsmessage" maxlength="100"></textarea>
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
    <script src="{{ asset('public/vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/vendor/bishopm/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/vendor/bishopm/summernote/summernote.min.js') }}" type="text/javascript"></script>
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
                    $('#smsrow1').removeClass('hidden');
                } else if (event.target.value=='email') {
                    $('#emailrow1').removeClass('hidden');
                    $('#emailrow2').removeClass('hidden');
                    $('#smsrow1').addClass('hidden');
                }
            });
            $('.msgtype').iCheck({
              radioClass: 'iradio_minimal-blue'
            });
            $('.grouprec').iCheck({
              radioClass: 'iradio_minimal-blue'
            });
            var maxLength = 100;
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