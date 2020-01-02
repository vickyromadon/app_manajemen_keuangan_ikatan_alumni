@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">
        {{ $data->type }}
    </h1>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <p class="lead">
                        {{ $data->message }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
