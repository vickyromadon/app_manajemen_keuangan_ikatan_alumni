@extends('layouts.admin')

@section('header')
    <h1>
        Kelola Iuran
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li>Iuran</li>
        <li class="active">Kelola</li>
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
                            <th>Alumni</th>
                            <th>Nominal</th>
                            <th>Tanggal Transfer</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach ($data->dana_contributions as $item)
                            @if ($item->status === "approve")
                                <tr>
                                    <td>{{ $i += 1 }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->nominal }}</td>
                                    <td>{{ $item->transfer_date }}</td>
                                    <td>{{ $item->description }}</td>
                                </tr>

                                @php
                                    $total += intval($item->nominal);
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-4">
                    {{-- <button class="btn btn-success btn-ls"><i class="fa fa-money"></i> Salurkan Dana</button>
                    <button class="btn btn-info btn-ls"><i class="fa fa-dollar"></i> Keluarkan Iuran</button> --}}
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>
                                    <h1>Total Iuran Terkumpul</h1>
                                </th>
                                <th>
                                    <h1>Rp. {{ number_format($total) }}</h1>
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
            $('#data_table').DataTable();
        });
    </script>
@endsection
