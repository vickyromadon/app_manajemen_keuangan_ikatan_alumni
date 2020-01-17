@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">
        {{ $data->title }}
    </h1>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title pull-left">
                        <i class="fa fa-user"></i> Posting oleh {{ $data->user->name }}
                    </h3>
                    <h3 class="box-title pull-right">
                        <i class="fa fa-calendar"></i> Posting pada {{ $data->created_at }}
                    </h3>
                </div>
                <div class="box-body">
                    <img class="img-fluid rounded" src="{{ asset('storage/'.$data->image) }}" alt="" style="width:100%; height:300px;">

                    <p class="lead">
                        {!! $data->description !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-body">
                            <h4>Tanggal Event <span class="pull-right">{{ $data->date }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>

            @if ( $data->date < date('Y-m-d') )
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible">
                        <h4><i class="icon fa fa-warning"></i> Informasi</h4>
                        Waktu untuk galang dana sudah habis, karena event sudah lewat.
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12">
                    <button id="btnGalang" class="btn btn-danger btn-flat col-md-12"><i class="fa fa-money"></i> Bantu Galang Dana</button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">Alumni Yang Sudah Melakukan Penggalangan Dana.</h3>
                </div>
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($data->dana_events as $item)
                            @if ( $item->status === "approve" )
                                <li class="item">
                                    <div class="product-img">
                                        @if ( $item->user->image !== null )
                                            <img src="{{ asset('storage/'.$item->user->image) }}" alt="Product Image">
                                        @else
                                            <img src="{{ asset('images/avatar_default.png') }}" alt="Product Image">
                                        @endif
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">{{ $item->user->name }}
                                            <span class="label label-warning pull-right">Rp. {{ $item->nominal }}</span></a>
                                        <span class="product-description">
                                            {{ $item->description }}
                                        </span>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@if (Auth::user())
    {{-- Modal Button Galang --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modalGalang">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formGalang" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="event_id" name="event_id" value="{{ $data->id }}">

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
                                <label class="col-sm-3 control-label">Tanggal Transfer</label>
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
                            <i class="fa fa-money"></i> Galang
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
            var url = null;
            $('#btnGalang').click(function () {
                @if( Auth::user() )
                    $('#formGalang')[0].reset();
                    $('#formGalang .modal-title').text("Mulai Galang");
                    $('#formGalang div.form-group').removeClass('has-error');
                    $('#formGalang .help-block').empty();
                    $('#formGalang button[type=submit]').button('reset');

                    $('#formGalang input[name="_method"]').remove();

                    url = "{{ route('donation.dana-event.add') }}";

                    $('#modalGalang').modal('show');
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

            $('#formGalang').submit(function (event) {
                event.preventDefault();
                $('#formGalang div.form-group').removeClass('has-error');
                $('#formGalang .help-block').empty();
                $('#formGalang button[type=submit]').button('loading');

                var formData = new FormData($("#formGalang")[0]);

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

                            $('#modalGalang').modal('hide');
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

                        $('#formGalang button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formGalang').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    console.log(data[key].name);
                                    var elem;
                                    if( $("#formGalang input[name='" + data[key].name + "']").length )
                                        elem = $("#formGalang input[name='" + data[key].name + "']");
                                    else if( $("#formGalang select[name='" + data[key].name + "']").length )
                                        elem = $("#formGalang select[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formGalang textarea[name='" + data[key].name + "']");

                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['proof'] != undefined){
                                $("#formGalang input[name='proof']").parent().find('.help-block').text(error['proof']);
                                $("#formGalang input[name='proof']").parent().find('.help-block').show();
                                $("#formGalang input[name='proof']").parent().parent().addClass('has-error');
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
                        $('#formGalang button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
