@extends('layouts.auth')

@section('title')
    <title>Admin | {{ env('APP_NAME') }}</title>
@endsection

@section('header')
    <a href="#"><b>Admin</b> {{ env('APP_NAME') }}</a>
@endsection

@section('content')
    <p class="login-box-msg">Masukkan Username dan Password</p>
    <form action="{{ route('admin.login') }}" method="post" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
            <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" placeholder="Masukkan Username" required autofocus>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
            <input id="password" type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <!-- /.col -->
            <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
            <!-- /.col -->
        </div>
    </form>
@endsection
