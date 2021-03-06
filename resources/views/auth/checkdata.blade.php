@extends('layouts.auth')

@section('title')
    <title>{{ env('APP_NAME') }}</title>
@endsection

@section('header')
    <a href="#">{{ env('APP_NAME') }}</a>
@endsection

@section('content')
    <p class="login-box-msg">Isi form di bawah ini dengan benar</p>
    @if($errors->has('data-error'))
        <p class="login-box-msg" style="color:red; font-weight:bold;">{{ $errors->first('data-error') }}</p>
    @endif

    <form action="{{ route('check-data') }}" method="post" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('nis') ? ' has-error' : '' }} has-feedback">
            <input id="nis" type="text" class="form-control" name="nis" readonly value="{{ Request()->nis }}">
            @if ($errors->has('nis'))
                <span class="help-block">
                    <strong>{{ $errors->first('nis') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }} has-feedback">
            <input id="fullname" type="text" class="form-control" name="fullname" readonly value="{{ Request()->fullname }}">
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
        <div class="form-group{{ $errors->has('entrydate') ? ' has-error' : '' }} has-feedback">
            <input id="entrydate" type="text" class="form-control" name="entrydate" value="{{ Request()->entrydate }}" readonly>
            @if ($errors->has('entrydate'))
                <span class="help-block">
                    <strong>{{ $errors->first('entrydate') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('outdate') ? ' has-error' : '' }} has-feedback">
            <input id="outdate" type="text" class="form-control" name="outdate" value="{{ Request()->outdate }}" readonly >
            @if ($errors->has('outdate'))
                <span class="help-block">
                    <strong>{{ $errors->first('outdate') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
            <input id="password" type="password" class="form-control" name="password" placeholder="Masukkan Password">
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback">
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Masukkan Ulangi Password">
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Selesai</button>
        </div>
    </form>
@endsection
