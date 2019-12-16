@extends('layouts.admin')

@section('header')
    <h1>
        Kritik dan Saran
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Kritik dan Saran</li>
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
                            <th>Judul</th>
                            <th>Tanggal Buat</th>
                            <th>Pengirim</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.message.destroy', ['id' => '#']) }}" method="post" id="formDelete">
                	{{ method_field('DELETE') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Hapus Kritik dan Saran</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menghapus Kritik dan Saran ?</p>
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
                            <th>Judul</th>
                            <td>:</td>
                            <td id="title"></td>
                        </tr>
                        <tr>
                            <th>Isi</th>
                            <td>:</td>
                            <td id="description"></td>
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
                    "url": "{{ route('admin.message.index') }}",
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
                        "data": "title",
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    },
                    {
                        "data": "user",
                        render: function (data, type, row){
                            return data.name;
                        },
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return	'<a href="#" class="view-btn btn btn-xs btn-info"><i class="fa fa-eye"> Lihat</i></a> &nbsp' +
                                	'<a href="#" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a>';
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
                $('#modalView .modal-title').text("Lihat Kritik dan Saran");

                var aData = JSON.parse($(this).parent().parent().attr('data'));

                $('#modalView #title').text(aData.title);
                $('#modalView #description').text(aData.description);

                $('#modalView').modal('show');
            });

            // Delete
            $('#data_table').on('click', '.delete-btn' , function(e){
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                url =  $('#formDelete').attr('action').replace('#', aData.id);
                $('#modalDelete').modal('show');
            });

            $('#formDelete').submit(function (event) {
                event.preventDefault();

                $('#modalDelete button[type=submit]').button('loading');
                var _data = $("#formDelete").serialize();

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            table.draw();

                            $.toast({
	                            heading: 'Success',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'success',
	                            loader : false
	                        });

                            $('#modalDelete').modal('toggle');
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
                        $('#modalDelete button[type=submit]').button('reset');
                        $('#formDelete')[0].reset();
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

                        $('#formDelete button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
