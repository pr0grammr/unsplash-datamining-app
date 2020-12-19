@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            Likes: {{ $photo->likes }}
            Downloads: {{ $photo->downloads }}
            Views: {{ $photo->views }}
            User: <a href="{{ route('unsplash-user-detail', $photo->user->id) }}">{{ $photo->user->username }}</a>
        </div>
    </div>
@endsection
