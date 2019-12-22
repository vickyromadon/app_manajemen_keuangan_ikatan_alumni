@extends('layouts.app')

@section('content')
    <div class="jumbotron bg-gray">
        <div class="container-fluid text-center">
            <h1>Event</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi saepe aliquam ut eius. Facere temporibus velit rerum! Ullam sequi est itaque, cumque recusandae minus vel corrupti distinctio consequatur doloremque sit?
            </p>
        </div>
    </div>

    @foreach ($event as $item)
    <div class="row">
        <div class="col-md-12">
            <!-- Blog Post -->
            <div class="card mb-4">
                <img class="card-img-top" src="{{ asset('storage/'.$item->image) }}" alt="Card image cap" style="width:100%; height:500px;">
                <div class="card-body">
                    <h2 class="card-title"><b>{{ $item->title }}</b></h2>
                    <p class="card-text">
                        @if (strlen($item->description) > 500)
                            {!! substr($item->description, 0, 500) !!} ...
                        @else
                            {!! $item->description !!}
                        @endif
                    </p>
                    <a href="{{ route('event.show', ['id' => $item->id]) }}" class="btn btn-primary pull-right">Baca Selanjutnya <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
                <div class="card-footer text-muted">
                    Ponsting pada {{ $item->created_at }} oleh
                    <a href="#">{{ $item->user->name }}</a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @endforeach

    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{ $event->links() }}
            </div>
        </div>
    </div>
@endsection
