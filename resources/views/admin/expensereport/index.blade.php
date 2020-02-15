@extends('layouts.admin')

@section('header')
    <h1>
        Laporan Keluar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Laporan Keluar</li>
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
                            <th>Kode</th>
                            <th>Tanggal Keluar</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                            <th>Nama Penyalur</th>
                            <th>Nama Penerima</th>
                            <th>Nama Bank</th>
                            <th>Nomor Rekening</th>
                            <th>Nama Pemilik Bank</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- view -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalView">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body">
                    <table style="border-spacing: 10px; border-collapse: separate;">
                        <tr>
                            <th>Bukti Transfer</th>
                            <td>:</td>
                            <td id="image"><img src="#" class="img-thumbnail" style="height:40vh; width:50vh;"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            var table = $('#data_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('admin.expense-report.index') }}",
                    "type": "POST",
                    "data" : {}
                },
                "language": {
                    "emptyTable": "Tidak Ada Data Tersedia",
                },
                "columns": [
                    {
                       data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                       "width": "20px",
                       "orderable": false,
                    },
                    {
                        "data": "code",
                        "orderable": true,
                    },
                    {
                        "data": "out_date",
                        "orderable": true,
                    },
                    {
                        "data": "type",
                        "orderable": true,
                    },
                    {
                        "data": "nominal",
                        "orderable": true,
                    },
                    {
                        "data": "sender",
                        "orderable": true,
                    },
                    {
                        "data": "receiver",
                        "orderable": true,
                    },
                    {
                        "data": "bank_name",
                        "orderable": false,
                    },
                    {
                        "data": "bank_number",
                        "orderable": false,
                    },
                    {
                        "data": "bank_owner",
                        "orderable": false,
                    },
                    {
                        "data": "description",
                        "orderable": false,
                    },
                    {
                        render : function(data, type, row){
                            return	'<a href="#" class="view-btn btn btn-xs btn-info"><i class="fa fa-eye"> Lihat Bukti</i></a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 2, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            // View
            $('#data_table').on('click', '.view-btn', function(e){
                $('#modalView .modal-title').text("Lihat Bukti Penyaluran Dana");

                var aData = JSON.parse($(this).parent().parent().attr('data'));

                if (aData.proof != null) {
                    $('#modalView #image img').attr("src", "{{ asset('storage/')}}" + "/" + aData.proof);
                } else {
                    $('#modalView #image img').attr("src", "{{ asset('images/default.jpg')}}");
                }

                $('#modalView').modal('show');
            });
        });
    </script>
@endsection
