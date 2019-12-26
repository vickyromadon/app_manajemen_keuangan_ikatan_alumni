@extends('layouts.admin')

@section('header')
    <h1>
        Pengelola Peranan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Pengelola Peranan</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <a href="{{ route('admin.role.create') }}" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Nama Tampilan</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- /.box-body -->

    <!-- add modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formAdd">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-horizontal">
                                {{ method_field('POST') }}
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Nama Peranan
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Peranan" required>
                                        <span id="error_name" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Nama Tampilan
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Masukkan Nama Tampilan" required>
                                        <span id="error_display_name" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Deskripsi
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Masukkan Deskripsi" required>
                                        <span id="error_description" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="box-body">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Kembali
                            </button>
                            <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- edit modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formEdit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-horizontal">
                                {{ method_field('POST') }}
                                <input type="hidden" name="id" value="">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Role Name
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Role Name" required>
                                        <span id="error_name" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Display Name
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Display Name" required>
                                        <span id="error_display_name" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Description
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
                                        <span id="error_description" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="box-body">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Kembali
                            </button>
                            <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- change password modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">

    </div>
@endsection

@section('js')
	<script type="text/javascript">
        jQuery(document).ready(function($) {

            var url;

            @if (session('success'))
                $.toast({
                    heading: 'Success',
                    text : "{{ session('success') }}",
                    position : 'top-right',
                    allowToastClose : true,
                    showHideTransition : 'plain',
                    icon : 'success',
                    loader : false
                });
            @endif

            @if (session('error'))
                $.toast({
                    heading: 'Error',
                    text : "{{ session('error') }}",
                    position : 'top-right',
                    allowToastClose : true,
                    showHideTransition : 'plain',
                    icon : 'error',
                    loader : false,
                    hideAfter: 5000
                });
            @endif

            /** Datatables Initialization **/
            var table = $('#dataTable').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('admin.role.index') }}",
                    "type": "POST",
                    "data" : {}
                },
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
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
                        "data": "name",
                        "orderable": true,
                    },
                    {
                        "data": "display_name",
                        "orderable": true,
                    },
                    {
                        "data": "description",
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return '<a href="/admin/role/' + row.id +'/edit" class="btn btn-sm btn-warning btn-xs"><i class="fa fa-pencil"></i> Ubah</a> &nbsp;';
                        },
                        "orderable": false,
                    }
                ],
                "order": [ 1, 'asc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            /** Add User **/
            $('#btnAdd').click(function () {
                $('#formAdd')[0].reset();
                $('#formAdd button[type=submit]').button('reset');
                $('#formAdd .modal-title').text("Tambah Pengguna");
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();

                url =  "{{ route('admin.role.store') }}";
                toastMessage = "Tambah Pengguna Berhasil";
                var data = $('#formAdd').serializeArray();
                $.each(data, function(key, value){
                    $('#error_' + data[key].name).hide();
                });

                $("#formAdd input[name='_method']").val('POST');

                $('#addModal').modal('show');
            });

            $('#formAdd').submit(function (event) {
                $('#formAdd button[type=submit]').button('loading');
                event.preventDefault();
                $('#formAdd div.form-group').removeClass('has-error');
                $('#formAdd .help-block').empty();

                var _data = $("#formAdd").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (data) {
                        if (data.success) {
                            table.draw();

                            $.toast({
                                heading: 'Success',
                                text : data.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'plain',
                                icon : 'success',
                                loader : false
                            });

                            $('#addModal').modal('hide');

                        } else {
                            $('#formAdd')[0].reset();
                        }
                    },

                    error: function(data){
                        var error = data.responseJSON;
                        var data = $('#formAdd').serializeArray();
                        $.each(data, function(key, value){
                            if( error.errors[data[key].name] != undefined ){
                                $('#error_' + data[key].name).text(error.errors[data[key].name]);
                                $('#error_' + data[key].name).show();
                                $('#' + data[key].name).parent().parent().addClass('has-error');
                                $('#formAdd button[type=submit]').button('reset');
                            }
                        });
                    }
                });
            });

            /** Edit User **/
            $('#dataTable').on('click', '.edit-btn', function(e){
                $('#formEdit button[type=submit]').button('reset');
                $('#formEdit .modal-title').text("Ubah Data Pengguna");
                $('#formEdit div.form-group').removeClass('has-error');
                $('#formEdit .help-block').empty();
                $('#formEdit')[0].reset();

                var aData = JSON.parse($(this).parent().parent().attr('data'));

                url =  "{{ route('admin.role.index') }}" + "/" + aData.id;
                toastMessage = "Ubah Data Pengguna Berhasil";
                var data = $('#formEdit').serializeArray();
                $.each(data, function(key, value){
                    $('#error_' + data[key].name).hide();
                });

                $("#formEdit input[name='id']").val(aData.id);
                $("#formEdit input[name='name']").val(aData.name);
                $("#formEdit input[name='phone']").val(aData.phone);
                $("#formEdit input[name='email']").val(aData.email);
                $("#formEdit input[name='_method']").val('PUT');

                $('#editModal').modal('show');
            });

            $('#formEdit').submit(function (event) {
                $('#formEdit button[type=submit]').button('loading');
                event.preventDefault();
                $('#formEdit div.form-group').removeClass('has-error');
                $('#formEdit .help-block').empty();

                var _data = $("#formEdit").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (data) {
                        if (data.success) {
                            table.draw();

                            $.toast({
                                heading: 'Success',
                                text : data.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'plain',
                                icon : 'success',
                                loader : false
                            });

                            $('#editModal').modal('hide');

                        } else {
                            $('#formEdit')[0].reset();
                        }
                    },

                    error: function(data){
                        var error = data.responseJSON;
                        var data = $('#formEdit').serializeArray();
                        $.each(data, function(key, value){
                            if( error.errors[data[key].name] != undefined ){
                                $('#error_' + data[key].name).text(error.errors[data[key].name]);
                                $('#error_' + data[key].name).show();
                                $('#' + data[key].name).parent().parent().addClass('has-error');
                                $('#formEdit button[type=submit]').button('reset');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
