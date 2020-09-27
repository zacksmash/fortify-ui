@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    You are logged in!

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            {{ __('Logout') }}
        </button>
    </form>
@endsection
