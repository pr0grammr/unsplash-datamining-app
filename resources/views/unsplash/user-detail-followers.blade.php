@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul>
                    @foreach($followers as $follower)
                        <li>
                            <img src="{{ $follower['profile_image']['medium'] }}" alt="{{ $follower['username'] }}">
                            <a href="{{ $follower['links']['html'] }}">{{ $follower['username'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="d-flex justify-content-center col-md-12">
                <ul class="pagination mt-5">
                    @for($i = 1; $i <= $pagination['total_pages']; $i++)
                        @if ($i == $pagination['current_page'])
                            <li class="page-item active"><a class="page-link" href="{{ route('unsplash-user-detail-followers', ['unsplashUser' => $user, 'page' => $i, 'limit' => $pagination['per_page']]) }}">{{ $i }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ route('unsplash-user-detail-followers', ['unsplashUser' => $user, 'page' => $i, 'limit' => $pagination['per_page']]) }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                </ul>
            </div>

            <a class="btn btn-primary" href="{{ route('unsplash-user-detail', $user) }}">Back to profile</a>
        </div>
    </div>
@endsection
