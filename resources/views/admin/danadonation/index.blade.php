@extends('layouts.admin')

@section('header')
    <h1>
        Dana Donation
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Dana Donation</li>
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
                            <th>Nama Alumni</th>
                            <th>Nominal</th>
                            <th>Tanggal Transfer</th>
                            <th>Bank Transfer</th>
                            <th>Donasi</th>
                            <th>Status</th>
                            <th>Tanggal Buat</th>
                            <th>Aksi</th>
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
                    "url": "{{ route('admin.dana-donation.index') }}",
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
                        "data": "user",
                        render : function(data, type, row){
                            return data.name;
                        },
                        "orderable": true,
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
                        "data": "donation",
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
                    },
                    {
                        render : function(data, type, row){
                            return '<a href="{{ route('admin.dana-donation.index') }}/'+ row.id +'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> Detail</a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 7, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection
