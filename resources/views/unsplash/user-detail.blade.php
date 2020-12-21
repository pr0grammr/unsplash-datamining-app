@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <a target="_blank" href="https://unsplash.com/{{ $user->username }}">
                                    <img src="{{ $user->profile_image['large'] }}" alt="{{ $user->username }}">
                                </a>
                            </div>
                            <div class="col-md-10">
                                <h1>{{ $user->username }}@if ($user->detection_mode == \App\Models\UnsplashUser::DETECTION_MODE_AUTO) <small>(automatically analyzed)</small>@endif</h1><p>{{ $user->name }}</p>
                                @if ($user->bio) <p>Bio: {{ $user->bio }}</p>@endif
                                @if ($user->location) <p>Location: {{ $user->location }}</p>@endif
                                @if ($user->instagram_username) <p>Instagram: <a title="Instagram" target="_blank" href="https://instagram.com/{{ $user->instagram_username }}">{{ $user->instagram_username }}</a></p>@endif
                                @if ($user->twitter_username) <p>Twitter: <a title="Twitter" target="_blank" href="https://twitter.com/{{ $user->twitter_username }}">{{ $user->twitter_username }}</a></p>@endif
                                <p><a href="{{ route('unsplash-user-detail-followers', $user) }}">Followers list</a></p>
                            </div>
                        </div>

                        <div class="row mb-12">
                            <div class="col-md-6">
                                <ul>
                                    <li>Photos: <strong>{{ number_format($user->total_photos, 0) }}</strong></li>
                                    <li>Likes: <strong>{{ number_format($user->total_likes, 0) }}</strong></li>
                                    <li>Views: <strong>{{ number_format($user->total_views, 0) }}</strong></li>
                                    <li>Downloads: <strong>{{ number_format($user->downloads, 0) }}</strong></li>
                                    <li>Collections: <strong>{{ number_format($user->total_collections, 0) }}</strong></li>
                                    <li>Following: <strong>{{ number_format($user->following_count, 0) }}</strong></li>
                                    <li>Followers: <strong>{{ number_format($user->followers_count, 0) }}</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
