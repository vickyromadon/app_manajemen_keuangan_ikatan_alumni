@extends('layouts.app')

@section('content')
    <div class="jumbotron bg-gray">
        <div class="container-fluid text-center">
            <h1>Bagian Pengurus</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi saepe aliquam ut eius. Facere temporibus velit rerum! Ullam sequi est itaque, cumque recusandae minus vel corrupti distinctio consequatur doloremque sit?
            </p>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Tahun Masuk</th>
                            <th>Tahun Keluar</th>
                            <th>Jurusan</th>
                            <th>Jabatan</th>
                            <th>Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                            @if ($item->roles[0]->name != 'superadmin' && $item->roles[0]->name != 'alumni')
                                <tr>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->dataset != null ? $item->dataset->entrydate : "-" }}</td>
                                    <td>{{ $item->dataset != null ? $item->dataset->outdate : "-" }}</td>
                                    <td>{{ $item->dataset != null ? $item->dataset->department : "-" }}</td>
                                    <td>{{ $item->roles[0]->display_name }}</td>
                                    <td>{{ $item->created_at }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(document).ready(function($){
            $(document).ready( function () {
                $('#data_table').DataTable();
            });
        });
    </script>
@endsection
