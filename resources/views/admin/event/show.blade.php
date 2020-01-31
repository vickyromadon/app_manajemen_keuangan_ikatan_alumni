@extends('layouts.admin')

@section('header')
    <h1>
        Kelola Event
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Event</li>
        <li class="active">Kelola</li>
    </ol>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Alumni</th>
                            <th>Nominal</th>
                            <th>Tanggal Transfer</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach ($data->dana_events as $item)
                            @if ($item->status === "approve")
                                <tr>
                                    <td>{{ $i += 1 }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->nominal }}</td>
                                    <td>{{ $item->transfer_date }}</td>
                                    <td>{{ $item->description }}</td>
                                </tr>

                                @php
                                    $total += intval($item->nominal);
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-4">
                    @if ($data->total_dana == 0)
                        <button id="btnSalurkanDana" class="btn btn-success btn-ls"><i class="fa fa-money"></i> Salurkan Dana</button>
                    @endif

                    @if ($data->total_contribution == 0)
                        <button id="btnKeluarkanIuran" class="btn btn-info btn-ls"><i class="fa fa-dollar"></i> Keluarkan Iuran</button>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            @if ($data->total_dana == 0)
                            <tr>
                                <th>Dana Terkumpul Sementara</th>
                                <th>Rp. {{ number_format($total) }}</th>
                            </tr>
                            @endif
                            <tr>
                                <th>Dana Disalurkan</th>
                                <th>Rp. {{ number_format($data->total_dana) }}</th>
                            </tr>
                            <tr>
                                <th>Dana Iuran Alumni</th>
                                <th>Rp. {{ number_format($data->total_contribution) }}</th>
                            </tr>
                            <tr>
                                <th>
                                    <h1>Total</h1>
                                </th>
                                <th>
                                    <h1>Rp. {{ number_format($data->total_dana + $data->total_contribution) }}</h1>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Salurkan Dana --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalSalurkanDana">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formSalurkanDana" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Salurkan Donasi</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menyalurkan donasi ini ?</p>

                        <input type="hidden" name="id_event" value="{{ $data->id }}">
                        <input type="hidden" name="nominal" value="{{ $total }}">
                        <textarea name="description" id="description" class="form-control" placeholder="Masukkan sesuatu" required></textarea>
                        <br>
                        <input type="text" name="receiver" id="receiver" class="form-control" placeholder="Masukkan Nama Penerima" required>
                        <br>
                        <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Masukkan Nama Bank" required>
                        <br>
                        <input type="number" name="bank_number" id="bank_number" class="form-control" placeholder="Masukkan Nomor Rekening" required>
                        <br>
                        <input type="text" name="bank_owner" id="bank_owner" class="form-control" placeholder="Masukkan Nama Pemilik" required>
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

    {{-- Keluarkan Iuran --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalKeluarkanIuran">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formKeluarkanIuran" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Keluarkan Iuran</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" name="id_event" value="{{ $data->id }}">

                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <h3 style="margin:0px; padding:0px;">
                                        Total Dana Iuran Rp. {{ number_format($total_contribution->dana) }}
                                    </h3>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nominal</label>

                                <div class="col-sm-9">
                                    <input type="number" id="nominal" name="nominal" class="form-control" min="10000" max="{{ $total_contribution->dana }}" placeholder="Masukkan Nominal">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Deskripsi</label>

                                <div class="col-sm-9">
                                    <textarea name="description" class="form-control" placeholder="Masukkan Sesuatu"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Penerima</label>

                                <div class="col-sm-9">
                                    <input type="text" id="receiver" name="receiver" class="form-control" placeholder="Masukkan Nama Penerima">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            $('#data_table').DataTable();

            var url;

            // SalurkanDana
            $('#btnSalurkanDana').click(function () {
                url = '{{ route("admin.event.salurkan-dana") }}';
                $('#modalSalurkanDana').modal('show');
            });

            $('#formSalurkanDana').submit(function (event) {
                event.preventDefault();
                $('#formSalurkanDana div.form-group').removeClass('has-error');
                $('#formSalurkanDana .help-block').empty();
                $('#formSalurkanDana button[type=submit]').button('loading');

                var formData = new FormData($("#formSalurkanDana")[0]);

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

                            $('#modalSalurkanDana').modal('hide');

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

                        $('#formSalurkanDana button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formSalurkanDana').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    console.log(data[key].name);
                                    var elem;
                                    if( $("#formSalurkanDana input[name='" + data[key].name + "']").length )
                                        elem = $("#formSalurkanDana input[name='" + data[key].name + "']");
                                    else if( $("#formSalurkanDana select[name='" + data[key].name + "']").length )
                                        elem = $("#formSalurkanDana select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formSalurkanDana textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                        }
                        else if (response.status === 400) {
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
                        $('#formSalurkanDana button[type=submit]').button('reset');
                    }
                });
            });

            // KeluarkanIuran
            $('#btnKeluarkanIuran').click(function () {
                url = '{{ route("admin.event.keluarkan-iuran") }}';
                $('#modalKeluarkanIuran').modal('show');
            });

            $('#formKeluarkanIuran').submit(function (event) {
                event.preventDefault();
                $('#formKeluarkanIuran div.form-group').removeClass('has-error');
                $('#formKeluarkanIuran .help-block').empty();
                $('#formKeluarkanIuran button[type=submit]').button('loading');

                var formData = new FormData($("#formKeluarkanIuran")[0]);

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

                            $('#modalKeluarkanIuran').modal('hide');

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

                        $('#formKeluarkanIuran button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formKeluarkanIuran').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    console.log(data[key].name);
                                    var elem;
                                    if( $("#formKeluarkanIuran input[name='" + data[key].name + "']").length )
                                        elem = $("#formKeluarkanIuran input[name='" + data[key].name + "']");
                                    else if( $("#formKeluarkanIuran select[name='" + data[key].name + "']").length )
                                        elem = $("#formKeluarkanIuran select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formKeluarkanIuran textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                        }
                        else if (response.status === 400) {
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
                        $('#formKeluarkanIuran button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
