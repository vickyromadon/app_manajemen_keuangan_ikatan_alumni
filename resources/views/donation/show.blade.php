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
                    <img class="img-fluid rounded" src="{{ asset('storage/'.$data->image) }}" alt="" style="width:100%">

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
                            <h4>Donasi Berakhir <span class="pull-right">{{ $data->donation_limit }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
