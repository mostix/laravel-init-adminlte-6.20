@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        @error('active')
        <div class="alert alert-danger mt-1">
            {{ $message }}
        </div>
        @enderror
        @error('username')
        <div class="alert alert-danger mt-1">
            {{ $message }}
        </div>
        @enderror
        @error('password')
        <div class="alert alert-danger mt-1">
            {{ $message }}
        </div>
        @enderror

        <div class="form-group row">
            <label for="username" class="col-md-12 col-form-label">{{ __('auth.username') }}</label>

            <div class="col-md-12">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                       name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-12 col-form-label">{{ __('auth.password') }}</label>

            <div class="col-md-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password">

            </div>
        </div>

        <div class="form-group">
            <select name="provider" id="provider" class="form-control">
                <option value="user" @if(old('provider') == 'user') selected @endif>Вътрешен потребител</option>
                <option value="customer" @if(old('provider') == 'customer') selected @endif>Външен потребител</option>
            </select>
        </div>

        <div class="form-group row">
            <div class="col-md-12 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('validation.attributes.rememberme') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-4">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    {{ __('auth.login') }}
                </button>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('auth.forgot_password') }}?
                    </a>
                @endif
            </div>
        </div>
    </form>
@endsection
