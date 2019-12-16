@extends('layouts.admin')

@section('header')
    <h1>
        Dataset
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Dataset</li>
    </ol>
@endsection

@section('content')
	<div class="box box-default">
        <div class="box-header with-border">
            <button id="btnAdd" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Nama Orang Tua</th>
                            <th>Tanggal Lahir</th>
                            <th>Tempat Lahir</th>
                            <th>Tahun Masuk</th>
                            <th>Tahun Keluar</th>
                            <th>Status</th>
                            <th>Tanggal Buat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- add and edit -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formAdd" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="id" name="id">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">NIS</label>

                                <div class="col-sm-9">
                                    <input type="text" id="nis" name="nis" class="form-control" placeholder="Masukkan NIS">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Lengkap</label>

                                <div class="col-sm-9">
                                    <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Masukkan Nama Lengkap">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Orang Tua</label>

                                <div class="col-sm-9">
                                    <input type="text" id="parent_name" name="parent_name" class="form-control" placeholder="Masukkan Nama Orang Tua">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tanggal Lahir</label>

                                <div class="col-sm-9">
                                    <input type="date" id="birthdate" name="birthdate" class="form-control" placeholder="Masukkan Tanggal Lahir">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tempat Lahir</label>

                                <div class="col-sm-9">
                                    <input type="text" id="birthplace" name="birthplace" class="form-control" placeholder="Masukkan Tempat Lahir">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tahun Masuk</label>

                                <div class="col-sm-9">
                                    <input type="text" id="entrydate" name="entrydate" class="form-control" placeholder="Masukkan Tahun Masuk">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tahun Keluar</label>

                                <div class="col-sm-9">
                                    <input type="text" id="outdate" name="outdate" class="form-control" placeholder="Masukkan Tahun Keluar">
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

    <!-- delete -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.dataset.destroy', ['id' => '#']) }}" method="post" id="formDelete">
                	{{ method_field('DELETE') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Hapus Dataset</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin menghapus Dataset ?</p>
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
            var table = $('#data_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('admin.dataset.index') }}",
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
                        "data": "nis",
                        "orderable": true,
                    },
                    {
                        "data": "fullname",
                        "orderable": true,
                    },
                    {
                        "data": "parent_name",
                        "orderable": true,
                    },
                    {
                        "data": "birthdate",
                        "orderable": true,
                    },
                    {
                        "data": "birthplace",
                        "orderable": true,
                    },
                    {
                        "data": "entrydate",
                        "orderable": true,
                    },
                    {
                        "data": "outdate",
                        "orderable": true,
                    },
                    {
                        "data": "status",
                        "orderable": true,
                    },
                    {
                        "data": "created_at",
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return	'<a href="#" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"> Ubah</i></a> &nbsp' +
                                	'<a href="#" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 1, 'asc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            // add
            $('#btnAdd').click(function () {
                $('#formAdd')[0].reset();
                $('#formAdd .modal-title').text("Tambah Dataset");
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd input[name="_method"]').remove();
                url = '{{ route("admin.dataset.store") }}';

                $('#modalAdd').modal('show');
            });

            // Edit
            $('#data_table').on('click', '.edit-btn', function(e){
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd .modal-title').text("Ubah Dataset");
                $('#formAdd')[0].reset();
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                $('#formAdd button[type=submit]').button('reset');

                $('#formAdd .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("admin.dataset.index") }}' + '/' + aData.id;

                $('#id').val(aData.id);
                $('#nis').val(aData.nis);
                $('#fullname').val(aData.fullname);
                $('#parent_name').val(aData.parent_name);
                $('#birthdate').val(aData.birthdate);
                $('#birthplace').val(aData.birthplace);
                $('#entrydate').val(aData.entrydate);
                $('#outdate').val(aData.outdate);
                $('#status').val(aData.status);

                $('#modalAdd').modal('show');
            });

            $('#formAdd').submit(function (event) {
                event.preventDefault();
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();
                $('#formAdd button[type=submit]').button('loading');

                var formData = new FormData($("#formAdd")[0]);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,
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

                            $('#modalAdd').modal('hide');
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

                        $('#formAdd button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formAdd').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    console.log(data[key].name);
                                    var elem;
                                    if( $("#formAdd input[name='" + data[key].name + "']").length )
                                        elem = $("#formAdd input[name='" + data[key].name + "']");
                                    else if( $("#formAdd select[name='" + data[key].name + "']").length )
                                        elem = $("#formAdd select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formAdd textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['image'] != undefined){
                                $("#formAdd input[name='image']").parent().find('.help-block').text(error['image']);
                                $("#formAdd input[name='image']").parent().find('.help-block').show();
                                $("#formAdd input[name='image']").parent().parent().addClass('has-error');
                            }
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
                        $('#formAdd button[type=submit]').button('reset');
                    }
                });
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
