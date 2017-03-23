<form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                {!! csrf_field() !!}

    <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
        <input name="name" class="form-control" value="{{ old('name') }}"
               placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
        <input type="password" name="password" class="form-control"
               placeholder="{{ trans('adminlte::adminlte.password') }}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}
                </label>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <button type="submit"
                    class="btn btn-primary btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}
            </button>
        </div>
        <!-- /.col -->
    </div>
</form>
<div class="auth-links">
    <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"
       class="text-center"
    >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>
    <br>
    @if (config('adminlte.register_url', 'register'))
        <a href="{{ url(config('adminlte.register_url', 'register')) }}"
           class="text-center"
        >Register as a user</a>
    @endif
</div>