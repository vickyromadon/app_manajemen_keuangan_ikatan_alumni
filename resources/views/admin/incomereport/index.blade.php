@extends('layouts.admin')

@section('header')
    <h1>
        Laporan Masuk
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Laporan Masuk</li>
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
                            <th>Tanggal Masuk</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                            <th>Deskripsi</th>
                            <th>Nama Alumni</th>
                            <th>Bank Transfer</th>
                        </tr>
                    </thead>
                </table>
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
                    "url": "{{ route('admin.income-report.index') }}",
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
                        "data": "entry_date",
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
                        "data": "description",
                        "orderable": true,
                    },
                    {
                        "data": "user",
                        render: function (data, type, row, meta) {
                            return data.name;
                        },
                        "orderable": true,
                    },
                    {
                        "data": "bank",
                        render: function (data, type, row, meta) {
                            return data.name;
                        },
                        "orderable": true,
                    }
                ],
                "order": [ 1, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection
