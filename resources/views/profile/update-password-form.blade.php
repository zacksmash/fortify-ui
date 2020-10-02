<form method="POST" action="{{ route('user-password.update') }}">
    @csrf
    @method('PUT')

    <div>
        <label>{{ __('Current Password') }}</label>
        <input type="password" name="current_password" required autocomplete="current-password" />
    </div>

    <div>
        <label>{{ __('Password') }}</label>
        <input type="password" name="password" required autocomplete="new-password" />
    </div>

    <div>
        <label>{{ __('Confirm Password') }}</label>
        <input type="password" name="password_confirmation" required autocomplete="new-password" />
    </div>

    <div>
        <button type="submit">
            {{ __('Save') }}
        </button>
    </div>
</form>

<hr>
