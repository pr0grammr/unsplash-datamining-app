@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <a target="_blank" href="{{ $photo->urls['full'] }}">
                                    <img src="{{ $photo->urls['regular'] }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="col-md-10"></div>
                        </div>

                        <div class="row mb-12">
                            <div class="col-md-6">
                                <ul>
                                    <li>Likes: <strong>{{ number_format($photo->likes, 0) }}</strong></li>
                                    <li>Views: <strong>{{ number_format($photo->views, 0) }}</strong></li>
                                    <li>Downloads: <strong>{{ number_format($photo->downloads, 0) }}</strong></li>
                                    <li>User: <strong><a href="{{ route('unsplash-user-detail', $photo->user) }}">{{ $photo->user->username }}</a></strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
