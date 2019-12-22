@extends('layouts.app')

@section('css')
<style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
        margin-bottom: 0;
        border-radius: 0;
    }

    /* Add a gray background color and some padding to the footer */
    footer {
        background-color: #f2f2f2;
        padding: 25px;
    }

    .carousel-inner img {
        width: 100%;
        /* Set width to 100% */
        margin: auto;
        min-height: 200px;
    }

    /* Hide the carousel text when the screen is less than 600 pixels wide */
    @media (max-width: 600px) {
        .carousel-caption {
            display: none;
        }
    }

    .logo {
        font-size: 200px;
    }
    @media screen and (max-width: 768px) {
        .col-sm-4 {
            text-align: center;
            margin: 25px 0;
        }
    }
}
</style>
@endsection

@section('content')
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @for ($i = 0; $i < count($slider); $i++)
            <div class="item {{ $i==0 ? 'item active' : 'item' }}">
                <img src="{{ asset('storage/'.$slider[$i]->image) }}" alt="Image" style="widht:100%; height:70vh;">
                <div class="carousel-caption">
                    <h3>{{ $slider[$i]->title }}</h3>
                    <p>{{ $slider[$i]->description }}</p>
                </div>
            </div>
            @endfor
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Kembali</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Lanjut</span>
        </a>
    </div>

    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <h2>TENTANG</h2>
                <h4>Lorem Ipsum Dolor</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia deserunt accusantium assumenda voluptates esse placeat commodi ipsam culpa voluptas ex magni cumque consequuntur maiores aperiam, quis ipsa laboriosam modi laudantium.</p>
            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-info-sign logo pull-right"></span>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-globe logo pull-left"></span>
            </div>
            <div class="col-sm-8">
                <h2>VISI & MISI</h2>
                <h4><strong>MISI:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, id. Expedita voluptatibus quos sunt nesciunt repudiandae? Dicta consequuntur alias iste facilis dolorem vero, deserunt earum quos qui ut expedita numquam?</h4>
                <p><strong>VISI:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus necessitatibus voluptas quaerat iusto exercitationem! Ullam voluptatem esse voluptatibus saepe, sed natus libero in minima repellendus aperiam tempora ad facilis voluptates?</p>
            </div>
        </div>
    </div>

    <hr>

    <div class="container-fluid text-center">
        <h2>BERITA</h2>
        <br>
        <div class="row">
            @foreach ($news as $item)
            <div class="col-sm-3">
                <div class="well" style="min-height:200px;">
                    <h4>
                        <b>{{ $item->title }}</b>
                    </h4>
                    <hr>
                    <p class="text-left">
                        @if (strlen($item->description) > 200)
                            {!! substr($item->description, 0, 200) !!} ... <a href="{{ route('news.show', ['id' => $item->id]) }}">Baca Selengkapnya</a>
                        @else
                            {!! $item->description !!}
                        @endif
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <hr>

    <div class="container-fluid text-center">
        <h2>EVENT</h2>
        <br>
        <div class="row">
            @foreach ($event as $item)
            <a href="{{ route('event.show', ['id' => $item->id]) }}">
                <div class="col-sm-4">
                    <img src="{{ asset('storage/'.$item->image) }}" class="img-responsive" style="width:100%; height:200px;" alt="Image">
                    <h4>
                        <b>{{ $item->title }}</b>
                    </h4>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <hr>

    <div class="container-fluid text-center">
        <h2>GALERI</h2>
        <br>
        <div class="row">
            @foreach ($galery as $item)
            <a href="{{ route('galery.show', ['id' => $item->id]) }}">
                <div class="col-sm-2">
                    <img src="{{ asset('storage/'.$item->image) }}" class="img-responsive" style="width:100%; height:100px;" alt="Image">
                    <h5>
                        <b>{{ $item->title }}</b>
                    </h5>
                </div>
            @endforeach
            </a>
        </div>
    </div>
@endsection
