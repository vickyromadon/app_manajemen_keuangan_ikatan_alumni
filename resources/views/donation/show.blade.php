@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">
        {{ $data->title }}
    </h1>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title pull-left">
                        <i class="fa fa-user"></i> Posting oleh {{ $data->user->name }}
                    </h3>
                    <h3 class="box-title pull-right">
                        <i class="fa fa-calendar"></i> Posting pada {{ $data->created_at }}
                    </h3>
                </div>
                <div class="box-body">
                    <img class="img-fluid rounded" src="{{ asset('storage/'.$data->image) }}" alt="" style="width:100%">

                    <p class="lead">
                        {!! $data->description !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header with-border" align="center">
                            <h3 class="box-title">
                                Donasi Berakhir
                            </h3>
                        </div>
                        <div class="box-body" align="center">
                            <h4>{{ $data->donation_limit }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header with-border" align="center">
                            <h3 class="box-title">
                                Cuplikan Video
                            </h3>
                        </div>
                        <div class="box-body" align="center">
                            @if ($data->link_video == null)
                                <h4>Tidak memiliki cuplikan video</h4>
                            @else
                                <iframe width="100%" height="315" src="http://www.youtube.com/embed/{{ $data->link_video }}" frameborder="0" allowfullscreen></iframe>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ( $data->donation_limit < date('Y-m-d') )
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible">
                        <h4><i class="icon fa fa-warning"></i> Informasi</h4>
                        Waktu untuk donasi sudah habis, dan Dana Donasi sudah di salurkan ke orang yang bersangkutan.
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12">
                    <button id="btnDonasi" class="btn btn-danger btn-flat col-md-12"><i class="fa fa-money"></i> Bantu Donasi</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if (Auth::user())
    {{-- Modal Button Donasi --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDonasi">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formDonasi" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                                <input type="hidden" id="kota_mandiri_id" name="kota_mandiri_id" value="{{ $data->id }}">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Nominal</label>

                                    <div class="col-sm-9">
                                        <input type="text" id="nominal" name="nominal" class="form-control" placeholder="Masukkan Nominal">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Bank Tujuan</label>

                                    <div class="col-sm-9">
                                        <select name="bank_id" id="bank_id" class="form-control">
                                            <option value="">-- Pilih Salah Satu --</option>
                                            @foreach ($bank as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->number }} - ( a/n : {{ $item->owner }} )</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        Tanggal Transfer
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" name="transfer_date" id="transfer_date" placeholder="Pilih Tanggal Transfer">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Upload Bukti</label>

                                    <div class="col-sm-9">
                                        <input type="file" id="proof" name="proof" class="form-control">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            <i class="fa fa-close"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            <i class="fa fa-money"></i> Donasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('js')
    <script>
        jQuery(document).ready(function($){
            var url = null;
            $('#btnDonasi').click(function () {
                @if( Auth::user() )
                    $('#formDonasi')[0].reset();
                    $('#formDonasi .modal-title').text("Mulai Donasi");
                    $('#formDonasi div.form-group').removeClass('has-error');
                    $('#formDonasi .help-block').empty();
                    $('#formDonasi button[type=submit]').button('reset');

                    $('#formDonasi input[name="_method"]').remove();

                    $('#modalDonasi').modal('show');
                @else
                    $.toast({
                        heading: 'Error',
                        text : "Silahkan Masuk Terlebih Dahulu",
                        position : 'top-right',
                        allowToastClose : true,
                        showHideTransition : 'fade',
                        icon : 'error',
                        loader : false,
                        hideAfter: 5000
                    });
                @endif
            });
        });
    </script>
@endsection
