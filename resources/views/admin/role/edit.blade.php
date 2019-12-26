@extends('layouts.admin')

@section('header')
    <h1>
        Ubah Peranan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Pengelola Peranan</li>
        <li class="active">Ubah Peranan</li>
    </ol>
@endsection

@section('content')
    <form action="{{ route('admin.role.update', ['role' => $role->id]) }}" method="POST">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ route('admin.role.index') }}" class="pull-right btn btn-warning">
                    <i class="fa fa-reply"></i> Kembali
                </a>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-5">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Tambah Peranan Baru</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="control-label" for="name">Nama Peranan</label>
                            @if($role->name == 'admin')
                            <input type="text" class="form-control" name="name" id="name" value="{{ $role->name }}" disabled>
                            @else
                            <input type="text" class="form-control" name="name" id="name" value="{{ $role->name }}">
                            {!! $errors->first('name','<p class="text-danger"><strong>:message</strong></p>') !!}
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('display_name') ? 'has-error' : '' }}">
                            <label class="control-label" for="display_name">Nama Tampilan</label>
                            <input type="text" class="form-control" name="display_name" id="display_name" value="{{ $role->display_name }}">
                            {!! $errors->first('display_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label class="control-label" for="description">Deskripsi</label>
                            <textarea class="form-control" name="description" id="description">{{ $role->description }}</textarea>
                            {!! $errors->first('description','<p class="text-danger"><strong>:message</strong></p>') !!}
                        </div>
                    </div>
                </div>
            </div>

            @if(count($permissions) > 0)
            <div class="col-md-7">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Pemberian Hak Akses</h3>
                    </div>
                    <div class="box-body" style="overflow-y: scroll; height: 350px;">
                        <table class="table table-hover table-striped table-condensed">
                            <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td style="width:25px;">
                                            @if($role->name == 'superadmin')
                                                <input type="checkbox" checked disabled class="icheck"/>
                                            @else
                                                @if($role->hasPermission($permission->name))
                                                  <input type="checkbox" class="icheck" name="permission[{{ $permission->id }}]" value="{{ $permission->id }}" checked>
                                                @else
                                                  <input type="checkbox" class="icheck" name="permission[{{ $permission->id }}]" value="{{ $permission->id }}">
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <label>{{ $permission->display_name }}</label><br />
                                            <small>{{ $permission->description }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-sm-12">
                <span class="btn-group pull-right">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </span>
            </div>
        </div>
    </form>
@endsection

@section('css')
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($) {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endsection
