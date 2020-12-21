@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <h1>Dashboard</h1>
            </div>

            <div class="col-md-12 mb-3 mt-3">
                <h2>Photos</h2>
            </div>

            @if ($photo['most_downloads'])
            <div class="col-md-4 text-center">
                <div class="card dashboard-card">
                    <div class="card-header">
                        most downloads
                    </div>
                    <div class="card-body">
                        <a href="{{ route('unsplash-photo-detail', $photo['most_downloads']->id) }}">
                            <img class="img-fluid" src="{{ $photo['most_downloads']->urls['regular'] }}">
                        </a>
                        <a class="username" href="{{ route('unsplash-user-detail', $photo['most_downloads']->user) }}">{{ $photo['most_downloads']->user->username }}</a>
                        <span class="downloads">{{ number_format($photo['most_downloads']->downloads, 0) }}</span>
                    </div>
                </div>
            </div>
            @endif

                @if ($photo['most_likes'])
                    <div class="col-md-4 text-center">
                        <div class="card dashboard-card">
                            <div class="card-header">
                                most likes
                            </div>
                            <div class="card-body">
                                <a href="{{ route('unsplash-photo-detail', $photo['most_likes']->id) }}">
                                    <img class="img-fluid" src="{{ $photo['most_likes']->urls['regular'] }}">
                                </a>
                                <a class="username" href="{{ route('unsplash-user-detail', $photo['most_likes']->user) }}">{{ $photo['most_likes']->user->username }}</a>
                                <span class="downloads">{{ number_format($photo['most_likes']->likes, 0) }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($photo['most_views'])
                    <div class="col-md-4 text-center">
                        <div class="card dashboard-card">
                            <div class="card-header">
                                most views
                            </div>
                            <div class="card-body">
                                <a href="{{ route('unsplash-photo-detail', $photo['most_views']->id) }}">
                                    <img class="img-fluid" src="{{ $photo['most_views']->urls['regular'] }}">
                                </a>
                                <a class="username" href="{{ route('unsplash-user-detail', $photo['most_views']->user) }}">{{ $photo['most_views']->user->username }}</a>
                                <span class="downloads">{{ number_format($photo['most_views']->views, 0) }}</span>
                            </div>
                        </div>
                    </div>
                @endif

            <div class="col-md-12 mb-3 mt-3">
                <h2>Users</h2>
            </div>

                @if ($user['most_downloads'])
                    <div class="col-md-4 text-center">
                        <div class="card dashboard-card">
                            <div class="card-header">
                                most downloads
                            </div>
                            <div class="card-body">
                                <a href="{{ route('unsplash-user-detail', $user['most_downloads']->id) }}">
                                    <img class="img-fluid" src="{{ $user['most_downloads']->profile_image['large'] }}">
                                </a>
                                <a class="username" href="{{ route('unsplash-user-detail', $user['most_views']->id) }}">{{ $user['most_views']->username }}</a>
                                <span class="downloads">{{ number_format($user['most_downloads']->downloads, 0) }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($user['most_likes'])
                    <div class="col-md-4 text-center">
                        <div class="card dashboard-card">
                            <div class="card-header">
                                most likes
                            </div>
                            <div class="card-body">
                                <a href="{{ route('unsplash-user-detail', $user['most_likes']->id) }}">
                                    <img class="img-fluid" src="{{ $user['most_likes']->profile_image['large'] }}">
                                </a>
                                <a class="username" href="{{ route('unsplash-user-detail', $user['most_views']->id) }}">{{ $user['most_views']->username }}</a>
                                <span class="downloads">{{ number_format($user['most_likes']->total_likes, 0) }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($user['most_views'])
                    <div class="col-md-4 text-center">
                        <div class="card dashboard-card">
                            <div class="card-header">
                                most views
                            </div>
                            <div class="card-body">
                                <a href="{{ route('unsplash-user-detail', $user['most_views']->id) }}">
                                    <img class="img-fluid" src="{{ $user['most_views']->profile_image['large'] }}">
                                </a>
                                <a class="username" href="{{ route('unsplash-user-detail', $user['most_views']->id) }}">{{ $user['most_views']->username }}</a>
                                <span class="downloads">{{ number_format($user['most_views']->total_views, 0) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
        </div>
    </div>
@endsection
