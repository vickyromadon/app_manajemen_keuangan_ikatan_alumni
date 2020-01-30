@extends('layouts.admin')

@section('header')
    <h1>
        Kelola Iuran
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Iuran</li>
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
                        @foreach ($data->dana_contributions as $item)
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
                    <button id="btnReminder" class="btn btn-warning btn-ls"><i class="fa fa-volume-up"></i> Peringatan</button>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>
                                    <h1>Total Iuran Terkumpul</h1>
                                </th>
                                <th>
                                    <h1>Rp. {{ number_format($total) }}</h1>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- reminder -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalReminder">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formReminder">
                    <input type="hidden" name="contribution_id" id="contribution_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Peringatan Membayar Iuran</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin melakukan peringatan membayar iuran ?</p>
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

@section('js')
	<script>
        jQuery(document).ready(function($){
            $('#data_table').DataTable();

            var url;

            // Reminder
            $('#btnReminder').click(function () {
                url = '{{ route("admin.contribution.reminder") }}';
                $('#modalReminder').modal('show');
            });

            $('#formReminder').submit(function (event) {
                event.preventDefault();

                $('#modalReminder button[type=submit]').button('loading');
                var _data = $("#formReminder").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
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

                            $('#modalReminder').modal('toggle');

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                        else{
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
                        $('#modalReminder button[type=submit]').button('reset');
                        $('#formReminder')[0].reset();
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }

                        $('#formReminder button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
