<?php

namespace Zacksmash\FortifyUI\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FortifyUICommand extends Command
{
    public $signature = 'fortify:ui {--skip-provider}';

    public $description = 'Setup FortifyUI routes, service providers and views';

    public function handle()
    {
        $this->publishAssets();
        $this->updateServiceProviders();
        $this->updateRoutes();

        $this->comment('FortifyUI is now installed.');

        if ($this->option('skip-provider')) {
            $this->info('Please, remember to include the Fortify view registrations!');
        }

        $this->info('Please, run php artisan migrate!');
    }

    protected function publishAssets()
    {
        $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);

        if (! $this->option('skip-provider')) {
            $this->callSilent('vendor:publish', ['--tag' => 'fortify-ui-provider', '--force' => true]);
        }

        $this->callSilent('vendor:publish', ['--tag' => 'fortify-ui-views', '--force' => true]);
    }

    public function updateServiceProviders()
    {
        $appConfig = file_get_contents(config_path('app.php'));

        if ($this->option('skip-provider')) {
            if (! Str::contains($appConfig, 'App\\Providers\\FortifyServiceProvider::class')) {
                File::put(
                    config_path('app.php'),
                    str_replace(
                        "App\Providers\RouteServiceProvider::class,",
                        "App\Providers\RouteServiceProvider::class,".PHP_EOL."        App\Providers\FortifyServiceProvider::class,",
                        $appConfig
                    )
                );
            }
        } else {
            if (
                ! Str::contains($appConfig, 'App\\Providers\\FortifyServiceProvider::class')
                &&
                ! Str::contains($appConfig, 'App\\Providers\\FortifyUIServiceProvider::class')
            ) {
                File::put(config_path('app.php'), str_replace(
                    "App\Providers\RouteServiceProvider::class,",
                    "App\Providers\RouteServiceProvider::class,".PHP_EOL."        App\Providers\FortifyServiceProvider::class,".PHP_EOL."        App\\Providers\\FortifyUIServiceProvider::class,",
                    $appConfig
                ));
            }
        }
    }

    protected function updateRoutes()
    {
        File::append(
            base_path('routes/web.php'),
            "\nRoute::view('dashboard', 'dashboard')\n\t->name('dashboard')\n\t->middleware(['auth', 'verified']);\n"
        );

        File::put(
            resource_path('views/welcome.blade.php'),
            str_replace(
                "{{ url('/home') }}",
                "{{ url('/dashboard') }}",
                File::get(resource_path('views/welcome.blade.php'))
            )
        );

        File::put(
            app_path('Providers/RouteServiceProvider.php'),
            str_replace(
                "public const HOME = '/home';",
                "public const HOME = '/dashboard';",
                File::get(app_path('Providers/RouteServiceProvider.php'))
            )
        );
    }
}
