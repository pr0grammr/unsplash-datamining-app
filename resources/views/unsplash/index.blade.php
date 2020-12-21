@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <div class="row justify-content-center">
            <form class="form-signin" method="POST" action="{{ route('unsplash-analyze') }}">
                @csrf

                <h1 class="h3 mb-3 font-weight-normal">Analyze</h1>
                <label for="unsplash-input">{{ __('Photo ID/URL or Username/URL') }}</label>
                <div class="col-md-12 mb-3">
                    <small>Username beginning with @</small>
                </div>
                <input id="unsplash-input" type="text" class="form-control mb-3 @error('unsplash-input') is-invalid @enderror" name="unsplash-input" value="{{ old('unsplash-input') }}" required autocomplete="unsplash-input" autofocus placeholder="Photo ID/URL or Username/URL">

                @error('email')
                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                @enderror

                <button type="submit" class="btn btn-primary">{{ __('Analyze') }}</button>
            </form>
        </div>
    </div>
@endsection
