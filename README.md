<p  align="center"><img  src="https://github.com/zacksmash/fortify-ui/raw/master/fortify-ui-image.png"  width="400"></p>

# Introduction

**FortifyUI** is an unopinionated authentication starter, powered by [*Laravel Fortify*](https://github.com/laravel/fortify). It is completely unstyled -- on purpose -- and only includes a minimal amount of markup to get your project running quickly. This package can be used to start your project, or you can use the [*FortifyUI Preset Template*](https://github.com/zacksmash/fortify-ui-preset) which allows you to create your own preset that you can install with **FortifyUI**.


### In a nutshell...
**FortifyUI** automates the base installation and configuration of *Laravel Fortify*, it includes the features that *Laravel Fortify* recommends implementing yourself and it provides the scaffolding for you to build your own UI around it. Hence, Fortify + UI.

---

- [Installation](#installation)
- [Configuration](#configuration)
- [Features](#features)
  - [Email Verification](#features-email-verification)
  - [Password Confirmation](#features-password-confirmation)
  - [Two-Factor Authentication](#features-two-factor-auth)
  - [Update User Password/Profile](#features-password-profile)
- [FortifyUI Presets](#presets)

<a name="installation"></a>
## Installation

To get started, you'll need to install **FortifyUI** using Composer. This will install *Laravel Fortify* as well so, please make sure you **do not** have it installed, already.

```bash
composer require zacksmash/fortify-ui
```

Next, you'll need to run the install command:

```bash
php artisan fortify:ui
```

This command will publish **FortifyUI's** views, add the `home` route to `web.php` and add the **FortifyUI** service provider to your `app/Providers` directory. This will also publish the service provider and config file for *Laravel Fortify*. Lastly, it will register both service providers in the `app.php` config file, under the providers array.

That's it, you're all setup! For advanced setup and configuration options, keep reading!

<a name="configuration"></a>
## Configuration

The **FortifyUI** service provider registers the views for all of the authentication features. If you'd rather **not** include the **FortifyUI** service provider, you can skip generating it by using the `--skip-provider` flag.

```bash
php artisan fortify:ui --skip-provider
```

Then, you can add this to your `AppServiceProvider` or `FortifyServiceProvider`, in the `boot()` method.

```php
Fortify::loginView(function () {
    return view('auth.login');
});

Fortify::registerView(function () {
    return view('auth.register');
});

Fortify::requestPasswordResetLinkView(function () {
    return view('auth.forgot-password');
});

Fortify::resetPasswordView(function ($request) {
    return view('auth.reset-password', ['request' => $request]);
});

// Fortify::verifyEmailView(function () {
//     return view('auth.verify-email');
// });

// Fortify::confirmPasswordView(function () {
//     return view('auth.confirm-password');
// });

// Fortify::twoFactorChallengeView(function () {
//     return view('auth.two-factor-challenge');
// });
```

To register all views at once, you can use this instead:

```php
Fortify::viewPrefix('auth.');
```

Now, you should have all of the registered views required by *Laravel Fortify*, including basic layout and home views, as well as optional password confirmation, email verification and two-factor authentication views.

<a name="features"></a>
## Features

By default, **FortifyUI** is setup to handle the basic authentication functions (Login, Register, Password Reset) provided by *Laravel Fortify*.

<a name="features-email-verification"></a>
### Email Verification
To enable the email verification feature, you'll need to visit the **FortifyUI** service provider and uncomment `Fortify::verifyEmailView()`, to register the view. Then, go to the `fortify.php` config file and make sure `Features::emailVerification()` is uncommented. Next, you'll want to update your `User` model to include the following:

```php
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    ...
```

This allows you to attach the `verified` middleware to any of your routes, which is handled by the `verify.blade.php` file.

[More info about this can be found here.](https://github.com/laravel/fortify/blob/1.x/README.md#email-verification)

<a name="features-password-confirmation"></a>
### Password Confirmation
To enable the password confirmation feature, you'll need to visit the **FortifyUI** service provider and uncomment `Fortify::confirmPasswordView()`, to register the view. This allows you to attach the `password.confirm` middleware to any of your routes, which is handled by the `password-confirm.blade.php` file.

<a name="features-two-factor-auth"></a>
### Two-Factor Authentication
To enable the two-factor authentication feature, you'll need to visit the **FortifyUI** service provider and uncomment `Fortify::twoFactorChallengeView()`, to register the view. Then, go to the `fortify.php` config file and make sure `Features::twoFactorAuthentication` is uncommented. Next, you'll want to update your `User` model to include the following:

```php
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;
    ...
```

That's it! Now, you can log into your application and enable or disable two-factor authentication.

<a name="features-password-profile"></a>
### Update User Password/Profile
To enable the ability to update user passwords and/or profile information, go to the `fortify.php` config file and make sure these features are uncommented:

```php
Features::updateProfileInformation(),
Features::updatePasswords(),
```

<a name="presets"></a>
## FortifyUI Presets

**FortifyUI** encourges make your own presets, with your favorite frontend libraries and frameworks. To get started, visit the [*FortifyUI Preset Template*](https://github.com/zacksmash/fortify-ui-preset) repository, and click the "Use Template" button.

### Community Presets

Here's a list of presets created by the community:

- [FortifyUIkit](https://github.com/zacksmash/fortify-uikit): Made with the UIkit framework
- [FortifyUITabler](https://github.com/Proxeuse/fortify-tabler): Made with the Tabler dashboard template
- [FortifyBulma](https://github.com/mikeburrelljr/fortify-bulma): Made with the Bulma CSS framework
- [FortifyUITailwind](https://github.com/pradeep3/fortify-ui-tailwindcss): Maide with the Tailwind CSS framework

If you've created a preset, please open an issue or PR to add it to the list!

## License

**FortifyUI** is open-sourced software licensed under the [MIT license](LICENSE.md).
