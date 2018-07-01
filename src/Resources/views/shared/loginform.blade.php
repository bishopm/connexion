<div class="form-group" id="emaildiv" style="display:none;">
    <div class="row">
        <div class="col-sm-6">
            <label for="emailbox">Your email address</label>
            <input id="emailbox" class="form-control" placeholder="Enter your email address">
        </div>
        <div class="col-sm-6">
            <label for="usernamebox">Recognise your username?</label>        
            <select id="usernamebox" class="form-control"></select>
        </div>
    </div>
</div>
<form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-sm-12">Login with your username and password</div>
        <br><br>
        <div class="col-sm-12">
            <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                <input id="name" name="name" class="form-control" value="{{ old('name') }}"
                    placeholder="Username">
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" name="password" class="form-control"
                    placeholder="{{ trans('adminlte::adminlte.password') }}">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}
                </label>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-sm-4">
            <button type="submit"
                    class="btn btn-primary btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}
            </button>
        </div>
        <!-- /.col -->
    </div>
</form>
<div class="auth-links">
    @if (config('adminlte.register_url', 'register'))
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ url(config('adminlte.register_url', 'register')) }}" class="text-center">
                    Register as a user
                </a>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}" class="text-center">
                I forgot my password
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a href="#" onclick="usernametell();" class="text-center">I forgot my username</a>
        </div>
    </div>
</div>