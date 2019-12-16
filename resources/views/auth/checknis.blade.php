@extends('layouts.auth')

@section('title')
    <title>{{ env('APP_NAME') }}</title>
@endsection

@section('header')
    <a href="#">{{ env('APP_NAME') }}</a>
@endsection

@section('content')
    <p class="login-box-msg">Masukkan NIS Anda</p>
    <form action="{{ route('check-nis') }}" method="post" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('nis') ? ' has-error' : '' }} has-feedback">
            <input id="nis" type="text" class="form-control" name="nis" value="{{ old('nis') }}" placeholder="Masukkan NIS" required autofocus>
            @if ($errors->has('nis'))
                <span class="help-block">
                    <strong>{{ $errors->first('nis') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <!-- /.col -->
            <button type="submit" class="btn btn-primary btn-block btn-flat">Periksa NIS</button>
            <!-- /.col -->
        </div>
    </form>
@endsection
