@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach($followers as $follower)
                <a href="{{ $follower['links']['html'] }}">{{ $follower['username'] }}</a>
            @endforeach

            <ul>
            @for($i = 1; $i <= $pagination['total_pages']; $i++)
                    <li><a href="{{ route('unsplash-user-detail-followers', ['unsplashUser' => $user, 'page' => $i, 'limit' => $pagination['per_page']]) }}">{{ $i }}</a></li>
                @endfor
            </ul>
        </div>
    </div>
@endsection
