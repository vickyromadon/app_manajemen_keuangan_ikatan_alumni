@extends('layouts.admin')

@section('header')
    <h1>
        Detail Pengguna
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Pengelola Pengguna</li>
        <li class="active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><strong>{{ $data->name }}</strong></h3>
            <a href="/admin/user" class="pull-right btn btn-warning"><i class="fa fa-reply"></i> Kembali</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>
                        <i class="fa fa-credit-card margin-r-5"></i>
                        NIS
                    </strong>
                    <p class="text-muted">
                        @if( $data->username != null )
                            {{ $data->username }}
                        @else
                            -
                        @endif
                    </p>

                    <strong>
                        <i class="fa fa-envelope margin-r-5"></i>
                        Email
                    </strong>
                    <p class="text-muted">
                        @if( $data->email != null )
                            {{ $data->email }}
                        @else
                            -
                        @endif
                    </p>

                    <strong>
                        <i class="fa fa-phone margin-r-5"></i>
                        Nomor Handphone
                    </strong>

                    <p class="text-muted">
                        @if( $data->phone != null )
                            {{ $data->phone }}
                        @else
                            -
                        @endif
                    </p>

                    <strong>
                        <i class="fa fa-map margin-r-5"></i>
                        Alamat
                    </strong>

                    <p class="text-muted">
                        @if( $data->address != null )
                            {{ $data->address }}
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    @if ( $data->dataset != null )
                    <strong>
                        <i class="fa fa-male margin-r-5"></i>
                        Nama Lengkap
                    </strong>

                    <p class="text-muted">
                        @if( $data->dataset->fullname != null )
                            {{ $data->dataset->fullname }}
                        @else
                            -
                        @endif
                    </p>

                    <strong>
                        <i class="fa fa-male margin-r-5"></i>
                        Nama Orang Tua
                    </strong>

                    <p class="text-muted">
                        @if( $data->dataset->parent_name != null )
                            {{ $data->dataset->parent_name }}
                        @else
                            -
                        @endif
                    </p>

                    <strong>
                        <i class="fa fa-calendar margin-r-5"></i>
                        Tanggal Lahir
                    </strong>

                    <p class="text-muted">
                        @if( $data->dataset->birthdate != null )
                            {{ $data->dataset->birthdate }}
                        @else
                            -
                        @endif
                    </p>

                    <strong>
                        <i class="fa fa-map-pin margin-r-5"></i>
                        Tempat Lahir
                    </strong>

                    <p class="text-muted">
                        @if( $data->dataset->birthplace != null )
                            {{ $data->dataset->birthplace }}
                        @else
                            -
                        @endif
                    </p>

                    <strong>
                        <i class="fa fa-calendar margin-r-5"></i>
                        Tahun Masuk Sekolah
                    </strong>

                    <p class="text-muted">
                        @if( $data->dataset->entrydate != null )
                            {{ $data->dataset->entrydate }}
                        @else
                            -
                        @endif
                    </p>

                    <strong>
                        <i class="fa fa-calendar margin-r-5"></i>
                        Tahun Lulus Sekolah
                    </strong>

                    <p class="text-muted">
                        @if( $data->dataset->outdate != null )
                            {{ $data->dataset->outdate }}
                        @else
                            -
                        @endif
                    </p>
                    @endif
                </div>
            </div>
        </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection
