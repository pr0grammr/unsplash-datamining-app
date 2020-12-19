@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form method="POST" action="{{ route('unsplash-analyze') }}">
                @csrf

                <div class="form-group row">
                    <label for="unsplash-input" class="col-md-4 col-form-label text-md-right">{{ __('Bild ID, Username oder URL') }}</label>

                    <div class="col-md-6">
                        <input id="unsplash-input" type="text" class="form-control @error('unsplash-input') is-invalid @enderror" name="unsplash-input" value="{{ old('unsplash-input') }}" required autocomplete="unsplash-input" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
