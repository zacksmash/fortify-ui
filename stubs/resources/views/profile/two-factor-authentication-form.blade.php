@if(! auth()->user()->two_factor_secret)
    {{-- Enable 2FA --}}
    <form method="POST" action="{{ route('two-factor.enable') }}">
        @csrf

        <button type="submit">
            {{ __('Enable Two-Factor') }}
        </button>
    </form>
@else
    {{-- Disable 2FA --}}
    <form method="POST" action="{{ route('two-factor.disable') }}">
        @csrf
        @method('DELETE')

        <button type="submit">
            {{ __('Disable Two-Factor') }}
        </button>
    </form>

    @if(session('status') == 'two-factor-authentication-enabled')
        {{-- Show SVG QR Code, After Enabling 2FA --}}
        <div>
            {{ __('Two factor authentication is now enabled. Please finish configuring two factor authentication below.') }}
        </div>

        <div>
            {{ __('Scan the QR code using your phone’s authenticator application, or click it to use an authenticator application on your current device.') }}
        </div>

        <div>
            <a href="{!! auth()->user()->twoFactorQrCodeUrl() !!}" rel="alternate" aria-label="2FA link">{!! auth()->user()->twoFactorQrCodeSvg() !!}</a>
        </div>

        <form method="POST" action="{{ route('two-factor.confirm') }}">
            @csrf

            <div>
                <label>{{ __('Enter current 2FA code from your authenticator application to confirm the setup has been successful.') }}</label>
                <input type="text" name="code" required autofocus autocomplete="off" />
            </div>

            <button type="submit">
                {{ __('Confirm 2FA code') }}
            </button>
        </form>

        {{-- Show 2FA Recovery Codes --}}
        <div>
            {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
        </div>

    @endif

    @if (session('status') == 'two-factor-authentication-confirmed')
        {{-- Show Confirmation Sucess, After 2FA Confirmation Code Entered Correctly --}}
        <div>
            Two factor authentication confirmed and enabled successfully.
        </div>
    @endif
    <div>
        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
            <div>{{ $code }}</div>
        @endforeach
    </div>

    {{-- Regenerate 2FA Recovery Codes --}}
    <form method="POST" action="{{ route('two-factor.recovery-codes') }}">
        @csrf

        <button type="submit">
            {{ __('Regenerate Recovery Codes') }}
        </button>
    </form>

@endif


<hr>
