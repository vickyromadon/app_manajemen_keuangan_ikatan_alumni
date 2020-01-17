@extends('layouts.app')

@section('content')
    <div class="jumbotron bg-gray">
        <div class="container-fluid text-center">
            <h1>Laporan Masuk</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi saepe aliquam ut eius. Facere temporibus velit rerum! Ullam sequi est itaque, cumque recusandae minus vel corrupti distinctio consequatur doloremque sit?
            </p>
        </div>
    </div>

	<div class="box box-primary">
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
                    "url": "{{ route('income-report.index') }}",
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
                        render: function (data, type, row, meta) {
                            if( data === "event" ){
                                return "Event";
                            } else if( data === "donation" ){
                                return "Donasi";
                            } else {
                                return "Iuran";
                            }
                        },
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
                        "orderable": false,
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
