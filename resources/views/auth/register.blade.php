@extends('layouts.app')

@section('content')
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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>{{ __('Name') }}</label>
        <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />

        <label>{{ __('Email') }}</label>
        <input type="email" name="email" value="{{ old('email') }}" required />

        <label>{{ __('Password') }}</label>
        <input type="password" name="password" required autocomplete="new-password" />

        <label>{{ __('Confirm Password') }}</label>
        <input type="password" name="password_confirmation" required autocomplete="new-password" />

        <a href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>

        <button type="submit">
            {{ __('Register') }}
        </button>
    </form>
@endsection
