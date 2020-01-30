@extends('layouts.admin')

@section('header')
    <h1>
        Detail Dana Event
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Dana Event</li>
        <li class="active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Bukti Transfer
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Kode Transaksi</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->code }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nominal</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                Rp. {{ $data->nominal }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nama Bank Transfer</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->bank->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>No. Rekening Bank</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->bank->number }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nama Pemilik Rekening</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->bank->owner }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Tanggal Transfer</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->transfer_date }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Bukti Transfer</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('storage/'.$data->proof) }}" class="img-thumbnail" style="width:100%; height:300px;">
                        </div>
                    </div>
                </div>
                @if ( $data->status == "pending" )
                    <div class="box-footer">
                        <button class="btn btn-danger pull-left" id="btnReject"><i class="fa fa-check"></i> Tolak</button>
                        <button class="btn btn-success pull-right" id="btnApprove"><i class="fa fa-close "></i> Setujui</button>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detail Pengalang Dana
                    </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Nama</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->user->name }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>Email</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->user->email == null ? '-' : $data->user->email }}
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <b>No Handphone</b>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                {{ $data->user->phone == null ? '-' : $data->user->phone }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- approve -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalApprove">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formApprove">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Setujui Dana Event</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menyetujui Dana Event ini ?</p>

                        <div class="form-horizontal">
                            <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- reject -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalReject">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formReject">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Batalkan Dana Event</h4>
                    </div>

                    <input type="hidden" id="id" name="id" value="{{ $data->id }}">

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin membatalkan Dana Event ini ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')]
    <script>
        jQuery(document).ready(function($){
            var url;

            // approve
            $('#btnApprove').click(function () {
                url = '{{ route("admin.dana-event.approve") }}';
                $('#modalApprove').modal('show');
            });

            $('#formApprove').submit(function (event) {
                event.preventDefault();
                $('#formApprove button[type=submit]').button('loading');

                var formData = new FormData($("#formApprove")[0]);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            $('#modalApprove').modal('hide');

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                        else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }

                        $('#formApprove button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 400) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        $('#formApprove button[type=submit]').button('reset');
                    }
                });
            });

            // reject
            $('#btnReject').click(function () {
                url = '{{ route("admin.dana-event.reject") }}';
                $('#modalReject').modal('show');
            });

            $('#formReject').submit(function (event) {
                event.preventDefault();
                $('#formReject button[type=submit]').button('loading');

                var formData = new FormData($("#formReject")[0]);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            $('#modalReject').modal('hide');

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                        else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }

                        $('#formReject button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 400) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        $('#formReject button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection

