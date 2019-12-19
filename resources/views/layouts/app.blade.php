<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="viewport" content="initial-scale=1.0">

    <title>{{ env('APP_NAME') }}</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    {{-- google font --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('css')
</head>

<body class="hold-transition skin-blue-light layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="/" class="navbar-brand">{{ env('APP_NAME') }}</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="{{(Request::segment(1) == '/' || Request::segment(1) == '') ? "active" : ""}}">
                                <a href="{{ route('index') }}">
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="{{(Request::segment(1) == 'news') ? "active" : ""}}">
                                <a href="{{ route('news.index') }}">
                                    Berita
                                </a>
                            </li>
                            <li class="{{(Request::segment(1) == 'galery') ? "active" : ""}}">
                                <a href="{{ route('galery.index') }}">
                                    Galeri
                                </a>
                            </li>
                            <li class="{{(Request::segment(1) == 'event') ? "active" : ""}}">
                                <a href="{{ route('event.index') }}">
                                    Event
                                </a>
                            </li>
                            <li class="{{(Request::segment(1) == 'donation') ? "active" : ""}}">
                                <a href="{{ route('donation.index') }}">
                                    Donasi
                                </a>
                            </li>
                            <li class="{{(Request::segment(1) == 'contribution') ? "active" : ""}}">
                                <a href="{{ route('contribution.index') }}">
                                    Iuran
                                </a>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" id="navbar-search-input"
                                    placeholder="Pencarian">
                            </div>
                        </form>
                    </div>

                    @if( !Auth::user() )
                    <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Masuk</a></li>
                        </ul>
                    </div>
                    @else
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Notifications Menu -->
                            <li class="dropdown notifications-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-success">0</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Memiliki 0 Notifikasi yang Belum di Baca
                                    </li>
                                    <li>
                                        <ul class="menu">
                                            <li>
                                                <a href="#"
                                                    title="Belum di buka"
                                                    class="bg-gray">
                                                    <h4>
                                                        Tipe
                                                    </h4>
                                                    <p>Pesan</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    @if ( Auth::user()->image != null )
                                        <img class="user-image" alt="User Image" src="{{ asset('storage/'. Auth::user()->image)}}">
                                    @else
                                        <img class="user-image" alt="User Image" src="{{ asset('images/avatar_default.png') }}">
                                    @endif

                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        @if ( Auth::user()->image != null )
                                            <img class="img-circle" alt="User Image" src="{{ asset('storage/'. Auth::user()->image)}}">
                                        @else
                                            <img class="img-circle" alt="User Image" src="{{ asset('images/avatar_default.png') }}">
                                        @endif

                                        <p>
                                            {{ Auth::user()->name }}
                                            <small>{{ Auth::user()->roles[0]->display_name }} Sejak {{ date_format(Auth::user()->created_at, 'M. Y') }}</small>
                                        </p>
                                    </li>

                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a href="{{ route('dana-event.index') }}">Riwayat Event</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="{{ route('dana-donation.index') }}">Riwayat Donasi</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="{{ route('dana-contribution.index') }}">Riwayat Iuran</a>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="user-footer">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <a href="{{ route('profile.index') }}" class="btn btn-default btn-flat">Profile</a>
                                            </div>
                                            <div class="col-xs-4">
                                                <a href="{{ route('message.index') }}" class="btn btn-default btn-flat">Pesan</a>
                                            </div>
                                            <div class="col-xs-4">
                                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Keluar
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container">
                <section class="content-header">
                    @yield('header')
                </section>

                <section class="content">
                    @yield('content')
                </section>

            </div>

        </div>

        <footer class="main-footer">
            <div class="container">
                <strong>Copyright &copy; 2020 <a href="#">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
            </div>
        </footer>
    </div>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/jquery.toast.min.js') }}"></script>

    @yield('js')
</body>

</html>
