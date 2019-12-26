@extends('layouts.admin')

@section('header')
    <h1>
        Pengelola Pengguna
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Pengelola Pengguna</li>
    </ol>
@endsection

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <button id="btnAdd" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="user_table" class="table table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Peranan</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- /.box-body -->

    <!-- change password modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="passwordModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formPassword">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Ubah Kata Sandi</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="box-body">
                                <input type="hidden" name="id" value="">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Pengguna
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Kata Sandi Baru
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi Baru" required>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">
                                        Ulangi Kata Sandi
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Kata Sandi" required>
                                        <span class="help-block"></span>
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

    <!-- roles change modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="rolesModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formRoles">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Ubah Role</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-horizontal">
                                <input type="hidden" name="id" value="">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Nama
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">
                                        Roles
                                    </label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" style="width: 100%;" name="role" required>
                                          <option value="">-- Pilih Salah Satu --</option>
                                          @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                          @endforeach
                                        </select>
                                        <span class="help-block"></span>
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

@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script type="text/javascript">
        jQuery(document).ready(function($) {

            $('#formAdd .select2').select2({
                dropdownParent: $('#addModal'),
                placeholder: "Select a role"
            });

            var url;

            /** Datatables Initialization **/
            var table = $('#user_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('admin.user.index') }}",
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
                        "data": "username",
                        "orderable": true,
                    },
                    {
                        "data": "name",
                        "orderable": true,
                    },
                    {
                       data: null,
                       render: function (data, type, row) {
                            let role = data.roles[0];
                            if (typeof role != 'undefined') {
                                return role.display_name;
                            } else {
                                return '-';
                            }
                       },
                    },
                    {
                        "data": "email",
                        render: function (data, type, row, meta) {
                            if (row.email !== null) {
                                return row.email;
                            } else {
                                return "-";
                            }
                        },
                        "orderable": true,
                    },
                    {
                        "data": "phone",
                        render: function (data, type, row, meta) {
                            if (row.phone !== null) {
                                return row.phone;
                            } else {
                                return "-";
                            }
                        },
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return '<a href="/admin/user/' + row.id +'" class="view-btn center btn btn-info btn-xs"><i class="fa fa-eye"></i> Lihat</a> &nbsp;' +
                                '<a href="#" class="password-btn center btn btn-default btn-xs"><i class="fa fa-unlock"></i> Reset</a> &nbsp;' +
                                '<a href="#" class="roles-btn center btn btn-primary btn-xs"><i class="fa fa-gear"></i> Roles</a>';
                        },
                        "width": "25%",
                        "orderable": false,
                    }
                ],
                "order": [ 1, 'asc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            /** Reset Password **/
            $('#user_table').on('click', '.password-btn', function(e){
                $('#formPassword button[type=submit]').button('reset');
                $('#formPassword div.form-group').removeClass('has-error');
                $('#formPassword .help-block').empty();
                $('#formPassword')[0].reset();

                var aData = JSON.parse($(this).parent().parent().attr('data'));

                url =  "{{ route('admin.user.reset_password') }}";
                toastMessage = "Ubah Kata Sandi Pengguna Berhasil";
                var data = $('#formPassword').serializeArray();
                $.each(data, function(key, value){
                    $("#formPassword input[name='" + data[key].name + "']").parent().find('.help-block').hide();
                });

                $("#formPassword input[name='id']").val(aData.id);
                $("#formPassword input[name='name']").val(aData.name);
                $("#formPassword input[name='password']").val(aData.password);
                $("#formPassword input[name='password_confirmation']").val(aData.password_confirmation);
                $('#passwordModal').modal('show');
            });

            $('#formPassword').submit(function (event) {
                $('#formPassword button[type=submit]').button('loading');
                event.preventDefault();
                $('#formPassword div.form-group').removeClass('has-error');
                $('#formPassword .help-block').empty();

                var _data = $("#formPassword").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
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

                            $('#passwordModal').modal('hide');
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });

                            $('#formPassword')[0].reset();
                        }

                        $('#formPassword button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formPassword').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    $("#formPassword input[name='" + data[key].name + "']").parent().find('.help-block').text(error[data[key].name]);
                                    $("#formPassword input[name='" + data[key].name + "']").parent().find('.help-block').show();
                                    $("#formPassword input[name='" + data[key].name + "']").parent().parent().addClass('has-error');
                                }
                            });
                        } else if (response.status === 400) {
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
                        } else {
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

                        $('#formPassword button[type=submit]').button('reset');
                    }
                });
            });

            /** Change Role **/
            $('#user_table').on('click', '.roles-btn', function(e){
                $('#formRoles button[type=submit]').button('reset');
                $('#formRoles div.form-group').removeClass('has-error');
                $('#formRoles .help-block').empty();
                $('#formRoles')[0].reset();

                var aData = JSON.parse($(this).parent().parent().attr('data'));

                url =  "{{ route('admin.user.change_role') }}";
                toastMessage = "Ubah Role Pengguna Berhasil";
                var data = $('#formRoles').serializeArray();
                $.each(data, function(key, value){
                    $("#formRoles input[name='" + data[key].name + "']").parent().find('.help-block').hide();
                });

                $("#formRoles input[name='id']").val(aData.id);
                $("#formRoles input[name='name']").val(aData.name);
                $("#formRoles option[value='" + aData.roles[0].id + "']").prop('selected', 'selected');
                $('#rolesModal').modal('show');
            });

            $('#formRoles').submit(function (event) {
                $('#formRoles button[type=submit]').button('loading');
                event.preventDefault();
                $('#formRoles div.form-group').removeClass('has-error');
                $('#formRoles .help-block').empty();

                var _data = $("#formRoles").serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
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

                            $('#rolesModal').modal('hide');
                        } else {
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

                            $('#formRoles')[0].reset();
                        }

                        $('#formRoles button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formRoles').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    $("#formRoles input[name='" + data[key].name + "']").parent().find('.help-block').text(error[data[key].name]);
                                    $("#formRoles input[name='" + data[key].name + "']").parent().find('.help-block').show();
                                    $("#formRoles input[name='" + data[key].name + "']").parent().parent().addClass('has-error');
                                }
                            });
                        } else if (response.status === 400) {
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
                        } else {
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

                        $('#formRoles button[type=submit]').button('reset');
                    }
                });
            });

        });
    </script>
@endsection
