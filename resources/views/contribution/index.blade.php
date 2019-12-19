@extends('layouts.app')

@section('content')
    <div class="jumbotron bg-gray">
        <div class="container-fluid text-center">
            <h1>Iuran</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi saepe aliquam ut eius. Facere temporibus velit rerum! Ullam sequi est itaque, cumque recusandae minus vel corrupti distinctio consequatur doloremque sit?
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Tanggal Buka</th>
                                    <th>Tanggal Tutup</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user())
    {{-- Modal Contribution --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalContribution">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formContribution" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="contribution_id" name="contribution_id" value="">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nominal</label>

                                <div class="col-sm-9">
                                    <input type="text" id="nominal" name="nominal" class="form-control" placeholder="Masukkan Nominal">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Bank Tujuan</label>

                                <div class="col-sm-9">
                                    <select name="bank_id" id="bank_id" class="form-control">
                                        <option value="">-- Pilih Salah Satu --</option>
                                        @foreach ($bank as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->number }} - ( a/n : {{ $item->owner }} )</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    Tanggal Transfer
                                </label>
                                <div class="col-sm-9">
                                    <input type="date" id="transfer_date" name="transfer_date" class="form-control" placeholder="Masukkan Tanggal Transfer">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Upload Bukti</label>

                                <div class="col-sm-9">
                                    <input type="file" id="proof" name="proof" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pesan</label>

                                <div class="col-sm-9">
                                    <textarea name="description" id="description" class="form-control" placeholder="Tuliskan Sesuatu"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            <i class="fa fa-close"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            <i class="fa fa-money"></i> Iuran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
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
                    "url": "{{ route('contribution.index') }}",
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
                        "data": "open_date",
                        "orderable": true,
                    },
                    {
                        "data": "close_date",
                        "orderable": true,
                    },
                    {
                        "data": "status",
                        render : function(data, type, row){
                            if(data === "open"){
                                return "Buka";
                            } else {
                                return "Tutup"
                            }
                        },
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            if (row.status === "open") {
                                return	'<a href="#" class="contribution-btn btn btn-xs btn-success"><i class="fa fa-money"> Iuran</i></a>';
                            } else {
                                return "-";
                            }
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

            // contribution
            $('#data_table').on('click', '.contribution-btn', function(e){
                @if( Auth::user() )
                    $('#formContribution')[0].reset();
                    $('#formContribution .modal-title').text("Mulai Iuran");
                    $('#formContribution div.form-group').removeClass('has-error');
                    $('#formContribution .help-block').empty();
                    $('#formContribution button[type=submit]').button('reset');

                    $('#formContribution input[name="_method"]').remove();

                    var aData = JSON.parse($(this).parent().parent().attr('data'));
                    $('#contribution_id').val(aData.id);

                    url = "{{ route('donation.dana-contribution.add') }}";

                    $('#modalContribution').modal('show');
                @else
                    $.toast({
                        heading: 'Error',
                        text : "Silahkan Masuk Terlebih Dahulu",
                        position : 'top-right',
                        allowToastClose : true,
                        showHideTransition : 'fade',
                        icon : 'error',
                        loader : false,
                        hideAfter: 5000
                    });
                @endif
            });

            $('#formContribution').submit(function (event) {
                event.preventDefault();
                $('#formContribution div.form-group').removeClass('has-error');
                $('#formContribution .help-block').empty();
                $('#formContribution button[type=submit]').button('loading');

                var formData = new FormData($("#formContribution")[0]);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            $('#modalContribution').modal('hide');
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

                        // setTimeout(function () {
                        //     location.reload();
                        // }, 2000);

                        $('#formContribution button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formContribution').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formContribution input[name='" + data[key].name + "']").length )
                                        elem = $("#formContribution input[name='" + data[key].name + "']");
                                    else if( $("#formContribution select[name='" + data[key].name + "']").length )
                                        elem = $("#formContribution select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formContribution textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['proof'] != undefined){
                                $("#formContribution input[name='proof']").parent().find('.help-block').text(error['proof']);
                                $("#formContribution input[name='proof']").parent().find('.help-block').show();
                                $("#formContribution input[name='proof']").parent().parent().addClass('has-error');
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
                        $('#formContribution button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection

