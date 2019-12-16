@extends('layouts.app')

@section('content')
    <div class="jumbotron bg-gray">
        <div class="container-fluid text-center">
            <h1>Galeri</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi saepe aliquam ut eius. Facere temporibus velit rerum! Ullam sequi est itaque, cumque recusandae minus vel corrupti distinctio consequatur doloremque sit?
            </p>
        </div>
    </div>

    <div class="container-fluid bg-3 text-center">
        <div class="row">
            @foreach ($galery as $item)
            <a href="{{ route('galery.show', ['id' => $item->id]) }}">
                <div class="col-sm-3">
                    <img src="{{ asset('storage/'.$item->image) }}" class="img-responsive" style="width:100%" alt="Image">
                    <h4>
                        <b>{{ $item->title }}</b>
                    </h4>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{ $galery->links() }}
            </div>
        </div>
    </div>
@endsection
