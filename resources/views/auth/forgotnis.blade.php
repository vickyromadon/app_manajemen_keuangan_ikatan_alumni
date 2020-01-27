@extends('layouts.auth')

@section('title')
    <title>{{ env('APP_NAME') }}</title>
@endsection

@section('header')
    <a href="#">{{ env('APP_NAME') }}</a>
@endsection

@section('content')
    <p class="login-box-msg">Form Lupa NIS</p>
    @if($errors->has('data-error'))
        <p class="login-box-msg" style="color:red; font-weight:bold;">{{ $errors->first('data-error') }}</p>
    @endif
    @if($errors->has('data-success'))
        <p class="login-box-msg" style="color:green; font-weight:bold;">{{ $errors->first('data-success') }}</p>
    @endif

    <form action="{{ route('forgot-nis') }}" method="post" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }} has-feedback">
            <input id="fullname" type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" placeholder="Masukkan Nama">
            @if ($errors->has('fullname'))
                <span class="help-block">
                    <strong>{{ $errors->first('fullname') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('parent_name') ? ' has-error' : '' }} has-feedback">
            <input id="parent_name" type="text" class="form-control" name="parent_name" value="{{ old('parent_name') }}" placeholder="Masukkan Nama Orang Tua">
            @if ($errors->has('parent_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('parent_name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('birthdate') ? ' has-error' : '' }} has-feedback">
            <input id="birthdate" type="date" class="form-control" name="birthdate" value="{{ old('birthdate') }}" placeholder="Masukkan Tanggal Lahir">
            @if ($errors->has('birthdate'))
                <span class="help-block">
                    <strong>{{ $errors->first('birthdate') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('birthplace') ? ' has-error' : '' }} has-feedback">
            <input id="birthplace" type="text" class="form-control" name="birthplace" value="{{ old('birthplace') }}" placeholder="Masukkan Tempat Lahir">
            @if ($errors->has('birthplace'))
                <span class="help-block">
                    <strong>{{ $errors->first('birthplace') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Masukkan Email">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Selesai</button>
        </div>
    </form>
@endsection
