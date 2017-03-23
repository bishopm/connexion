@extends('adminlte::master')

@section('adminlte_css')
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    <link href="{{ asset('/vendor/bishopm/css/selectize.css') }}" rel="stylesheet" type="text/css" />
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><b>Umhlali</b> Methodist Church</a>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (isset($errmsg))
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul><li>{{ $errmsg }}</li></ul>
        </div>
    @endif    

    <div class="register-box-body">
        <p class="login-box-msg"><b>Register as a new user</b></p>
        <p class="login-box-msg">Choose a unique username and enter your email address below. If your details and email address are in our existing database, you'll be able to link your account to that record and we'll send you a mail to make sure you are you who say you are :) If your name or email address are not on our system, we'll follow up with you via the email address you supply here.</p>
        <form action="{{ url('/register') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
                <input class="form-control" placeholder="Username" name="name" value="{{ old('name') }}"/>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email') }}"/>
                <span class="fa fa-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <select class="selectize" placeholder="Find your name in our database" name="individual_id" id="individual_id" value="{{ old('individual_id') }}"/>
                </select>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password"/>
                <span class="fa fa-key form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation"/>
                <span class="fa fa-sign-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                  <a href="{{ url('/login') }}" class="text-center">I have already registered</a>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div><!-- /.col -->
            </div>
        </form>
    </div><!-- /.form-box -->
</div><!-- /.register-box -->


@endsection

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    <script src="{{ asset('vendor/bishopm/js/selectize.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $.ajaxSetup({
              headers: {
                 'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
              }
            });
            $('.selectize').selectize({
                openOnFocus: 1
            });
            $('#email').on('blur',function(e){
                email=e.target.value;
                $(".selectize")[0].selectize.clearOptions();
                if (email){
                    $.post('checkmail', { "email": email}, 
                    function(data){
                        var selectize = $(".selectize")[0].selectize;
                        if (data!=="No data"){
                            var indivs = $.parseJSON(data);
                            for (var i = 0; i < indivs.length; i++) {
                                selectize.addOption({
                                    text:indivs[i].surname + ', ' + indivs[i].firstname,
                                    value: indivs[i].id
                                });
                                selectize.open();
                            }
                        } else {
                            selectize.addOption({
                                    text:'Matching record not found in database',
                                    value: 0
                            });
                            selectize.open();
                        }
                    }); 
                }
            });                   
        });
    </script>
    @yield('js')
@stop
