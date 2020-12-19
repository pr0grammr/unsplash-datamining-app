@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <p>Username: {{ $user->username }}</p>
            <p>Firstname: {{ $user->first_name }}</p>
            <p>Lastname: {{ $user->last_name }}</p>
            <p>Location: {{ $user->location }}</p>
            <p>Bio: {{ $user->bio }}</p>
            <p>Twitter: {{ $user->twitter_username }}</p>
            <p>Instagram: {{ $user->instagram_username }}</p>
            <p>Likes: {{ $user->total_likes }}</p>
            <p>Photos: {{ $user->total_photos }}</p>
            <p>Collections: {{ $user->total_collections }}</p>
            <p>Following: {{ $user->following_count }}</p>
            <p>Followers: {{ $user->followers_count }}</p>
            <p>Downloads: {{ $user->downloads }}</p>
        </div>
    </div>
@endsection
