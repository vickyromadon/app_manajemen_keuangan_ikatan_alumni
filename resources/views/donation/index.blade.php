@extends('layouts.app')

@section('content')
    <div class="jumbotron bg-gray">
        <div class="container-fluid text-center">
            <h1>Donasi</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi saepe aliquam ut eius. Facere temporibus velit rerum! Ullam sequi est itaque, cumque recusandae minus vel corrupti distinctio consequatur doloremque sit?
            </p>
        </div>
    </div>

    @foreach ($donation as $item)
    <div class="row">
        <div class="col-md-5">
            <a href="#">
                <img class="img" src="{{ asset('storage/'.$item->image) }}" alt="" style="width:100%; height:300px;">
            </a>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <h3>
                        <b>{{ $item->title }}</b>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4 class="pull-left">
                        <i class="fa fa-user"></i>
                        <b>Di posting oleh</b> : {{ $item->user->name }}
                    </h4>
                </div>
                <div class="col-md-6">
                    <h4 class="pull-right">
                        <i class="fa fa-calendar"></i>
                        <b>Di posting Tanggal</b> : {{ $item->created_at }}
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" align="justivy">
                    @if (strlen($item->description) > 500)
                        {!! substr($item->description, 0, 500) !!} ...
                    @else
                        {!! $item->description !!}
                    @endif
                </div>
            </div>
            @if (strlen($item->description) > 500)
                <a class="btn btn-primary pull-right" href="{{ route('donation.show', ['id' => $item->id]) }}">
                    Baca Selengkapnya
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            @endif
        </div>
    </div>
    <hr>
    @endforeach

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{ $donation->links() }}
            </div>
        </div>
    </div>
@endsection
