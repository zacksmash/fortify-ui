@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div>
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div>
            <div>{{ __('Whoops! Something went wrong.') }}</div>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label>{{ __('Email') }}</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus />

        <label>{{ __('Password') }}</label>
        <input type="password" name="password" required autocomplete="current-password" />

        <label>{{ __('Remember me') }}</label>
        <input type="checkbox" name="remember">

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif

        <button type="submit">
           {{ __('Login') }}
        </button>
    </form>
@endsection
