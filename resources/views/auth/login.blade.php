@extends('layouts.auth')

@section('title')
    <title>{{ env('APP_NAME') }}</title>
@endsection

@section('header')
    <a href="#">{{ env('APP_NAME') }}</a>
@endsection

@section('content')
    <p class="login-box-msg">Masukkan NIS dan Kata Sandi</p>
    <form action="{{ route('login') }}" method="post" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Masukkan NIS" required autofocus>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
            <input id="password" type="password" class="form-control" name="password" placeholder="Masukkan Kata Sandi" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>

            <div class="row">
                <div class="col-md-2">
                    <p class="pull-left"><a href="{{ route('index') }}"><u>Home</u></a></p>
                </div>
                <div class="col-md-10">
                    <p class="pull-right">Belum Memiliki Akun ? <a href="{{ route('check-nis') }}"><u>Daftar Sekarang</u></a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="pull-left"><a href="{{ route('forgot-nis') }}"><u>Lupa NIS</u></a></p>
                </div>
                <div class="col-md-6">
                    <p class="pull-right"><a href="{{ route('forgot-password') }}"><u>Lupa Kata Sandi</u></a></p>
                </div>
            </div>
        </div>
    </form>
@endsection
