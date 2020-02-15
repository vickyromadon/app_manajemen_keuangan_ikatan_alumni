@extends('layouts.admin')

@section('header')
    <h1>
        Pembukuan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Pembukuan</li>
    </ol>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-header with-border">
    		<form>
            	<div class="row">
                    <div class="form-group col-md-8">
                    	<span class="form-group-addon"><b>&nbsp;</b></span>
                        <div id="periode_date" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span></span> <b class="caret"></b>
                        </div>
                    </div>
                    <div class="form-group col-md-4 align-bottom">
                    	<span class="form-group-addon"><b>&nbsp;</b></span>
                        <button id="btnFilter" class="form-control btn btn-md btn-primary"><i class="fa fa-filter"></i> Menyaring</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Pemasukkan</th>
                            <th>Pengeluaran</th>
                            <th>Total</th>
                            <th>Tanggal di Buat</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align:right">Total : </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endsection

@section('js')
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

	<script>
        jQuery(document).ready(function($){
            var table = $('#data_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('admin.accountancy.index') }}",
                    "type": "POST",
                    "dataType": 'json',
                    "data" : function(d){
                        return $.extend({},d,{
                            "periode_date" : $('#periode_date span').text(),
                        });
                    }
                },
                "dom": 'Bfrtip',
                "buttons": [
                    'csv', 'excel', 'pdf', 'print'
                ],
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
                        "data": "date",
                        "orderable": true,
                    },
                    {
                        "data": "income",
                        "orderable": true,
                    },
                    {
                        "data": "expense",
                        "orderable": true,
                    },
                    {
                        "data": "total",
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    }
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // Total over this page
                    pageTotalPemasukkan = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    pageTotalPengeluaran = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    let pageTotal   = pageTotalPemasukkan - pageTotalPengeluaran;
                    $( api.column( 3 ).footer() ).html(
                        pageTotalPemasukkan
                    );
                    $( api.column( 4 ).footer() ).html(
                        pageTotalPengeluaran
                    );
                    $( api.column( 5 ).footer() ).html(
                        pageTotal
                    );
                },
                "order": [ 6, 'desc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            $('#btnFilter').click(function (e) {
                e.preventDefault();
                table.draw();
            });
        });
    </script>

    <script>
        $(function() {
            var start = moment().startOf('year');
            var end = moment().endOf('year');

            function cb(start, end) {
                $('#periode_date span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            }

            $('#periode_date').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                   'Hari ini': [moment(), moment()],
                   'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                   'Minggu ini' : [moment().startOf('week'), moment().endOf('week')],
                   '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
                   'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                   'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                   'Tahun ini' : [moment().startOf('year'), moment().endOf('year')]
                }
            }, cb);
            cb(start, end);
        });
    </script>
@endsection
