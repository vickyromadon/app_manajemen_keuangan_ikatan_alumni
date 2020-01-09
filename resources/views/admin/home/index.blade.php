@extends('layouts.admin')

@section('header')
    <h1>
    Dashboard
    <small>Admin</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Dashboard</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $danaContribution }}</h3>

                    <p>Dana Iuran Tertunda</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bank"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $danaEvent }}</h3>

                    <p>Dana Event Tertunda</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $danaDonation }}</h3>

                    <p>Dana Donasi Tertunda</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
