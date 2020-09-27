<?php

namespace Zacksmash\FortifyUI\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FortifyUICommand extends Command
{
    public $signature = 'fortify-ui:install {--skip-provider}';

    public $description = 'Setup Fortify UI routes, service providers and views';

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
            $this->callSilent('vendor:publish', ['--tag' => 'provider', '--force' => true]);
        }

        $this->callSilent('vendor:publish', ['--tag' => 'views', '--force' => true]);
    }

    public function updateServiceProviders()
    {
        $appConfig = file_get_contents(config_path('app.php'));

        if ($this->option('skip-provider')) {
            if (! Str::contains($appConfig, 'App\\Providers\\FortifyServiceProvider::class')) {
                file_put_contents(config_path('app.php'), str_replace(
                    "App\Providers\RouteServiceProvider::class,",
                    "App\Providers\RouteServiceProvider::class,".PHP_EOL."        App\Providers\FortifyServiceProvider::class,",
                    $appConfig
                ));
            }
        } else {
            if (
                ! Str::contains($appConfig, 'App\\Providers\\FortifyServiceProvider::class')
                &&
                ! Str::contains($appConfig, 'App\\Providers\\FortifyUIServiceProvider::class')
            ) {
                file_put_contents(config_path('app.php'), str_replace(
                    "App\Providers\RouteServiceProvider::class,",
                    "App\Providers\RouteServiceProvider::class,".PHP_EOL."        App\Providers\FortifyServiceProvider::class,".PHP_EOL."        App\\Providers\\FortifyUIServiceProvider::class",
                    $appConfig
                ));
            }
        }
    }

    protected function updateRoutes()
    {
        file_put_contents(
            base_path('routes/web.php'),
            "\nRoute::view('home', 'home')\n\t->name('home')\n\t->middleware(['auth', 'verified']);\n",
            FILE_APPEND
        );
    }
}
