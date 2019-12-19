<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | {{ env('APP_NAME') }}</title>

    <!-- Google Font -->
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('css')
</head>

<body class="hold-transition skin-purple-light sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{ route('admin.index') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>ADM</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Admin</b> Alumni</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Notifications Menu -->
                        {{-- <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-danger">{{ $countUnreadNotif }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Memiliki {{ $countUnreadNotif }} Notifikasi yang Belum di Baca</li>
                                <li>
                                    <ul class="menu">
                                        @foreach ($dataNotif as $data)
                                            <li>
                                                <a href="{{ $data->link }}?id={{$data->id}}" title="{{ $data->status == \App\Models\Notification::STATUS_UNREAD ? 'Belum di buka' : '' }}" class="{{ $data->status == \App\Models\Notification::STATUS_UNREAD ? 'bg-gray' : '' }}">
                                                    <h4>
                                                        {{ $data->type }}
                                                    </h4>
                                                    <p>{{ $data->message }}</p>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li> --}}

                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                @if ( Auth::user()->image != null )
                                    <img class="user-image" alt="User Image" src="{{ asset('storage/'. Auth::user()->image)}}">
                                @else
                                    <img class="user-image" alt="User Image" src="{{ asset('images/avatar_default.png') }}">
                                @endif
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
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
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    @if( Auth::user()->roles[0]->name != "superadmin" )
                                        <div class="pull-left">
                                            <a href="{{ route('admin.profile.index') }}" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                    @endif
                                    <div class="pull-right">
                                        <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Keluar
                                        </a>

                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        @if ( Auth::user()->image != null )
                            <img class="img-circle" style="height:5vh; width:100%;" alt="User Image" src="{{ asset('storage/'. Auth::user()->image)}}">
                        @else
                            <img class="img-circle" alt="User Image" src="{{ asset('images/avatar_default.png') }}">
                        @endif
                    </div>
                    <div class="pull-left info">
                        <p>{{ Auth::user()->name }}</p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dataset.index') }}">
                            <i class="fa fa-folder"></i> <span>Dataset</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.news.index') }}">
                            <i class="fa fa-folder"></i> <span>Berita</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.galery.index') }}">
                            <i class="fa fa-folder"></i> <span>Galeri</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.contribution.index') }}">
                            <i class="fa fa-folder"></i> <span>Iuran</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dana-contribution.index') }}">
                            <i class="fa fa-folder"></i> <span>Dana Iuran</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.event.index') }}">
                            <i class="fa fa-folder"></i> <span>Event</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dana-event.index') }}">
                            <i class="fa fa-folder"></i> <span>Dana Event</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.donation.index') }}">
                            <i class="fa fa-folder"></i> <span>Donasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dana-donation.index') }}">
                            <i class="fa fa-folder"></i> <span>Dana Donasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.message.index') }}">
                            <i class="fa fa-folder"></i> <span>Kritik dan Saran</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.slider.index') }}">
                            <i class="fa fa-folder"></i> <span>Slider</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bank.index') }}">
                            <i class="fa fa-folder"></i> <span>Bank</span>
                        </a>
                    </li>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('header')
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="#">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
        </footer>
        <!-- /.control-sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/js/jquery.toast.min.js') }}"></script>
    @yield('js')
</body>

</html>
