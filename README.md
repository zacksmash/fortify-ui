<p  align="center"><img  src="https://github.com/zacksmsh/fortify-ui/blob/master/fortifu-ui-image.png"  width="400"></p>

# Introduction

FortifyUI is an unopinionated authentication starter, powered by [Laravel Fortify](https://github.com/laravel/fortify). This package can be used to start your project, or it can be forked to integrate your favorite frontend framework. It is completely unstyled on purpose and only includes a minimal amount of markup to get your project running quickly.

- [Installation](#installation)
- [Features](#features)

<a name="installation"></a>
## Installation

To get started, you'll need to install [Laravel Fortify](https://github.com/laravel/fortify) and follow the instructions to configure it. Next, install FortifyUI using Composer:

```bash
composer require zacksmash/fortify-ui laravel/fortify
```

Next, publish FortifyUI's resources:

```bash
php artisan vendor:publish --provider="Zacksmash\FortifyUI\FortifyUIServiceProvider"
```

This command will publish FortifyUI's service provider to your `app/Providers` directory. You should ensure this file is registered within the `providers` array of your `app` configuration file.

```php
'providers' => [
    ...
    App\Providers\FortifyServiceProvider::class,
    App\Providers\FortifyUIServiceProvider::class,
],
```

This will also publish the required views for Laravel Fortify view registration, including a basic home view, as well as optional password confirmation and email verification views.

Lastly, you should run the `fortify-ui` command from the terminal:

```bash
php artisan fortify-ui
```

This will update your routes file with the `home` route.

<a name="features"></a>
## Features

By default, FortifyUI is setup to handle the basic authentication functions (Login, Register, Password Reset) provided by Laravel Fortify.

### Email Verification
To enable the email verification feature, you'll need to visit the `FortifyUIServiceProvider` and uncomment the `Fortify::verifyEmailView()` feature. Next, you'll need to follow the instructions from [Laravel Fortify's](https://github.com/laravel/fortify/blob/1.x/README.md#email-verification) documentation to update your `User` model and the `fortify.php` config file. This allows you to attach the `verified` middleware to any of your routes, which is handled by the `verify.blade.php` file.

### Password Confirmation
To enable the password confirmation feature, you'll need to visit the `FortifyUIServiceProvider` and uncomment the `Fortify::confirmPasswordView()` feature. This allows you to attach the `password.confirm` middleware to any of your routes, which is handled by the `password-confirm.blade.php` file.

## License

FortifyUI is open-sourced software licensed under the [MIT license](LICENSE.md).
