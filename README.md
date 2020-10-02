<p  align="center"><img  src="https://github.com/zacksmash/fortify-ui/blob/master/fortify-ui-image.png"  width="400"></p>

# Introduction

**FortifyUI** is an unopinionated authentication starter, powered by [*Laravel Fortify*](https://github.com/laravel/fortify). This package can be used to start your project, or you can use the [*FortifyUI Preset Template*](https://github.com/zacksmash/fortify-ui-preset) to create your own preset to install with **FortifyUI**. It is completely unstyled -- on purpose -- and only includes a minimal amount of markup to get your project running quickly.

- [Installation](#installation)
- [Configuration](#configuration)
- [Features](#features)
- [FortifyUI Presets](#presets)

<a name="installation"></a>
## Installation

To get started, you'll need to install **FortifyUI** using Composer. This will install *Laravel Fortify* as well so, please make sure you **do not** have it installed, already.

```bash
composer require zacksmash/fortify-ui
```

Next, you'll need to run the install command:

```bash
php artisan fortify-ui:install
```

This command will publish **FortifyUI's** views, add the `home` route to `web.php` and add the **FortifyUI** service provider to your `app/Providers` directory.

That's it, you're all setup! For advanced setup and configuration options, keep reading!

<a name="configuration"></a>
## Configuration

If you'd rather not include the service provider file, you can skip generating it by using the `--skip-provider` flag.

```bash
php artisan fortify-ui:install --skip-provider
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
```

To register all views at once, you can use this instead:

```php
Fortify::viewPrefix('auth.');
```

Now, you should have all of the registered routes and views required by *Laravel Fortify*, including basic layout and home views, as well as optional password confirmation and email verification views.

<a name="features"></a>
## Features

By default, **FortifyUI** is setup to handle the basic authentication functions (Login, Register, Password Reset) provided by *Laravel Fortify*.

### Email Verification
To enable the email verification feature, you'll need to visit the **FortifyUI** service provider and uncomment the `Fortify::verifyEmailView()` feature. Next, you'll need to follow the instructions from [*Laravel Fortify's*](https://github.com/laravel/fortify/blob/1.x/README.md#email-verification) documentation to update your `User` model and the `fortify.php` config file. This allows you to attach the `verified` middleware to any of your routes, which is handled by the `verify.blade.php` file.

### Password Confirmation
To enable the password confirmation feature, you'll need to visit the **FortifyUI** service provider and uncomment the `Fortify::confirmPasswordView()` feature. This allows you to attach the `password.confirm` middleware to any of your routes, which is handled by the `password-confirm.blade.php` file.

<a name="presets"></a>
## FortifyUI Presets

**FortifyUI** encourges make your own presets, with your favorite frontend libraries and frameworks. To give you an idea of what that looks like, please take a look at [*FortifyUIkit*](https://github.com/zacksmash/fortify-uikit) and use the [*FortifyUI Preset Template*](https://github.com/zacksmash/fortify-ui-preset) to create your own.

## License

**FortifyUI** is open-sourced software licensed under the [MIT license](LICENSE.md).
