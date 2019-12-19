@extends('layouts.app')

@section('header')
	<h1>
		Riwayat
		<small>Iuran Bulanan</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
		<li class="active">Riwayat Iuran</li>
	</ol>
@endsection

@section('content')
	<div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nominal</th>
                            <th>Tanggal Transfer</th>
                            <th>Bank Transfer</th>
                            <th>Donasi</th>
                            <th>Status</th>
                            <th>Tanggal Buat</th>
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
                    "url": "{{ route('dana-contribution.index') }}",
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
                        "data": "nominal",
                        "orderable": true,
                    },
                    {
                        "data": "transfer_date",
                        "orderable": true,
                    },
                    {
                        "data": "bank",
                        render : function(data, type, row){
                            return data.name;
                        },
                        "orderable": true,
                    },
                    {
                        "data": "contribution",
                        render : function(data, type, row){
                            return data.title;
                        },
                        "orderable": true,
                    },
                    {
                        "data": "status",
                        render : function(data, type, row){
                            if(data === "pending"){
                                return "Tertunda";
                            } else if(data === "approve"){
                                return "Disetujui"
                            } else {
                                return "Ditolak"
                            }
                        },
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    }
                ],
                "order": [ 6, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection
