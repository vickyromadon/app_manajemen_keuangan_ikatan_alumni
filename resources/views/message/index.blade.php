@extends('layouts.app')

@section('header')
	<h1>
		Pesan
		<small>Kritik dan Saran</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
		<li class="active">Pesan</li>
	</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-6">
            <h3 class="text-center">Kirim Kritik dan Saran ke Pengurus {{ env('APP_NAME') }}</h3>
            <form class="form-horizontal" method="POST" id="formMessage">
                <div class="form-group">
                    <label class="col-sm-1 control-label">Judul</label>

                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan Judul">

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">Kritik dan Saran</label>

                    <div class="col-sm-11">
                        <textarea name="description" id="description" class="form-control" rows="10" cols="100" placeholder="Masukkan Kritik dan Saran"></textarea>

                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                        <button type="submit" class="btn btn-danger"><i class="fa fa-send"></i> Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#formMessage').submit(function (event) {
                event.preventDefault();
    		 	$('#formMessage button[type=submit]').button('loading');
    		 	$('#formMessage div.form-group').removeClass('has-error');
    	        $('#formMessage .help-block').empty();

    		 	var _data = $("#formMessage").serialize();

    		 	$.ajax({
                    url: "{{ route('message.index') }}",
                    method: 'POST',
                    data: _data,
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

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
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
                        }

                        $('#formMessage')[0].reset();
                        $('#formMessage button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formMessage').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formMessage input[name='" + data[key].name + "']").length )
                                        elem = $("#formMessage input[name='" + data[key].name + "']");
                                    else if( $("#formMessage textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formMessage textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formMessage select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
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
                        $('#formMessage button[type=submit]').button('reset');
                    }
                });
    		});
        });
    </script>
@endsection
