@extends('layouts.app')

@section('header')
	<h1>
		Profile
		<small>Alumni</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
		<li class="active">Profile</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Profile</h3>
                </div>
				<div class="box-body box-profile">
					@if ( $data->image != null )
                        <img class="profile-user-img img-responsive img-circle" style="height:20vh; width:20vh;" src="{{ asset('storage/'. $data->image)}}">
                    @else
                        <img class="profile-user-img img-responsive img-circle" src="{{ asset('images/avatar_default.png') }}">
                    @endif

                    <h3 class="profile-username text-center">{{ $data->name }}</h3>

                    <ul class="list-group list-group-unbordered">
						<li class="list-group-item">
                            <b>NIS</b>
                            <p class="pull-right">
								@if( $data->username != null )
									{{ $data->username }}
								@else
									-
								@endif
							</p>
						</li>
						<li class="list-group-item">
                            <b>Nama Lengkap</b>
                            <p class="pull-right">
								@if( $data->name != null )
									{{ $data->name }}
								@else
									-
								@endif
							</p>
						</li>
						<li class="list-group-item">
                            <b>Email</b>
                            <p class="pull-right">
								@if( $data->email != null )
									{{ $data->email }}
								@else
									-
								@endif
							</p>
						</li>
						<li class="list-group-item">
							<b>Nomor Handphone</b>
							<p class="pull-right">
								@if( $data->phone != null )
									{{ $data->phone }}
								@else
									-
								@endif
							</p>
						</li>
						<li class="list-group-item">
							<b>Alamat</b>
							<p class="pull-right">
								@if( $data->address != null )
									{{ $data->address }}
								@else
                                    -
								@endif
							</p>
						</li>
                        <li class="list-group-item">
                            <b>Status Akses</b>
                            <p class="pull-right">
                                {{ $data->roles[0]->display_name }}
                            </p>
                        </li>
					</ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#settings" data-toggle="tab">Pengaturan</a></li>
					<li><a href="#password" data-toggle="tab">Ubah Kata Sandi</a></li>
                    <li><a href="#avatar" data-toggle="tab">Ubah Foto Profile</a></li>
                </ul>

                <div class="tab-content">
					<!-- setting -->
					<div class="active tab-pane" id="settings">
						<form class="form-horizontal" method="POST" id="formSetting">
							<div class="form-group">
								<label class="col-sm-3 control-label">Nama</label>

								<div class="col-sm-9">
									<input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Email</label>

								<div class="col-sm-9">
									<input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">No Handphone</label>

								<div class="col-sm-9">
									<input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan Nomor Handphone">

									<span class="help-block"></span>
								</div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Alamat</label>

                                <div class="col-sm-9">
                                    <textarea name="address" id="address" class="form-control" placeholder="Masukkan Alamat"></textarea>

                                    <span class="help-block"></span>
                                </div>
                            </div>
							<div class="form-group">
			                    <div class="col-sm-offset-3 col-sm-9">
                                      <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
			                    </div>
		                  	</div>
						</form>
					</div>
                    <!-- end setting -->

                    <!-- password -->
					<div class="tab-pane" id="password">
						<form class="form-horizontal" method="POST" id="formPassword">
							<div class="form-group">
								<label class="col-sm-4 control-label">Kata Sandi Lama</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan Kata Sandi Lama">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Kata Sandi Baru</label>

								<div class="col-sm-8">
									<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan Kata Sandi Baru">

									<span class="help-block"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Konfirmasi Kata Sandi</label>

								<div class="col-sm-8">
									<input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="Masukkan Konfirmasi Kata Sandi">

									<span class="help-block"></span>
								</div>
							</div>

							<div class="form-group">
			                    <div class="col-sm-offset-4 col-sm-8">
			                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
			                    </div>
		                  	</div>
						</form>
					</div>
                    <!-- password -->

                    <div class="tab-pane" id="avatar">
                        <form class="form-horizontal" method="POST" id="formAvatar">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Foto Profile</label>

                                <div class="col-sm-9">
									<input type="file" class="form-control" id="image" name="image">

									<span class="help-block"></span>
								</div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#formSetting #name').val("{{ $data->name }}");
            $('#formSetting #phone').val("{{ $data->phone }}");
            $('#formSetting #email').val("{{ $data->email }}");
            $('#formSetting #address').val("{{ $data->address }}");

            $('#formSetting').submit(function (event) {
                event.preventDefault();
    		 	$('#formSetting button[type=submit]').button('loading');
    		 	$('#formSetting div.form-group').removeClass('has-error');
    	        $('#formSetting .help-block').empty();

    		 	var _data = $("#formSetting").serialize();

    		 	$.ajax({
                    url: "{{ route('profile.change-setting', ['id' => $data->id]) }}",
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

                        $('#formSetting')[0].reset();
                        $('#formSetting button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formSetting').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formSetting input[name='" + data[key].name + "']").length )
                                        elem = $("#formSetting input[name='" + data[key].name + "']");
                                    else if( $("#formSetting textarea[name='" + data[key].name + "']").length )
                                        elem = $("#formSetting textarea[name='" + data[key].name + "']");
                                    else
                                        elem = $("#formSetting select[name='" + data[key].name + "']");
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
                        $('#formSetting button[type=submit]').button('reset');
                    }
                });
    		});

            $('#formPassword').submit(function (event) {
    			event.preventDefault();
    		 	$('#formPassword button[type=submit]').button('loading');
    			$('#formPassword div.form-group').removeClass('has-error');
    	        $('#formPassword .help-block').empty();

    		 	var _data = $("#formPassword").serialize();

    		 	$.ajax({
                    url: "{{ route('profile.change-password', ['id' => $data->id]) }}",
                    method: 'POST',
                    data: _data,
                    cache: false,

                    success: function (response) {
                        if ( response.success ) {
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
                        }
                        else{
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

                        $('#formPassword button[type=submit]').button('reset');
                        $('#formPassword')[0].reset();
                    },

    					error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formPassword').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formPassword input[name='" + data[key].name + "']").length ? $("#formPassword input[name='" + data[key].name + "']") : $("#formPassword select[name='" + data[key].name + "']");
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
                        $('#formPassword button[type=submit]').button('reset');
                	}
                });
    		});

            $('#formAvatar').submit(function (event) {
                event.preventDefault();
                $('#formAvatar button[type=submit]').button('loading');
                $('#formAvatar div.form-group').removeClass('has-error');
                $('#formAvatar .help-block').empty();

                var formData = new FormData($("#formAvatar")[0]);

                $.ajax({
                    url: "{{ route('profile.change-avatar', ['id' => $data->id]) }}",
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

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
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
                        $('#formAvatar button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            if(error['image'] != undefined){
                                $("#formAvatar input[name='image']").parent().find('.help-block').text(error['image']);
                                $("#formAvatar input[name='image']").parent().find('.help-block').show();
                                $("#formAvatar input[name='image']").parent().parent().addClass('has-error');
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
                        $('#formAvatar button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection
