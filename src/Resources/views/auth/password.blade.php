@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('public/vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box" style="width:480px;">
        <div class="login-logo">
            <a href="{{ url('/') }}">{!!$setting['site_logo']!!}</a>
        </div><!-- /.login-logo -->

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

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

        <div class="login-box-body">
            <div class="form-group top10" id="emaildiv" style="display:none;">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="emailbox">Your email address</label>
                        <input id="emailbox" class="form-control" placeholder="Enter your email address">
                    </div>
                    <div class="col-xs-6">
                        <label for="usernamebox">Recognise your username?</label>        
                        <select id="usernamebox" class="form-control"></select>
                    </div>
                </div>
            </div>
            <p class="login-box-msg">Reset your password</p>
            <form action="{{ url('/password/email') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input id="name" class="form-control" placeholder="Username" name="name" value="{{ old('name') }}"/>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-2">
                    </div><!-- /.col -->
                    <div class="col-xs-8">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Send Password Reset Link</button>
                    </div><!-- /.col -->
                    <div class="col-xs-2">
                    </div><!-- /.col -->
                </div>
            </form>

            <a href="{{ url('/login') }}">Log in</a><br>
            <a href="{{ url('/register') }}" class="text-center">Register a new user</a><br>
            <a href="#" onclick="usernametell();" class="text-center">I forgot my username</a>
        </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    <script src="{{ asset('public/vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        @include('connexion::shared.login-modal-script')
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop