@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="login-container">
    <div class="login-form">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
        </div>
        <h2>{{ __('Register') }}</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Name') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email Address') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </form>
    </div>
</div>
@endsection
