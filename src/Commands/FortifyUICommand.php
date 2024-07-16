<?php

namespace Zacksmash\FortifyUI\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class FortifyUICommand extends Command
{
    public $signature = 'fortify:ui {--skip-provider}';

    public $description = 'Setup FortifyUI routes, service providers and views';

    public function handle()
    {
        try {
            $this->publishAssets();
            $this->updateServiceProviders();
            $this->updateRoutes();

            $this->components->info('Fortify scaffolding installed successfully.');

            if ($this->option('skip-provider')) {
                $this->components->info('Remember to register your Fortify views and migrate your database.');
            } else {
                $this->components->info('Remember to migrate your database.');
            }
        } catch (\Throwable $th) {
            $this->components->error('An error occurred while installing Fortify scaffolding.');
            $this->components->error($th->getMessage());
        }
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
        if (! method_exists(ServiceProvider::class, 'addProviderToBootstrapFile')) {
            return;
        }

        ServiceProvider::addProviderToBootstrapFile(
            \App\Providers\FortifyServiceProvider::class
        );

        if (! $this->option('skip-provider')) {
            ServiceProvider::addProviderToBootstrapFile(
                \App\Providers\FortifyUIServiceProvider::class
            );
        }
    }

    protected function updateRoutes()
    {
        // Add the Dashboard route to the web.phph routes file
        File::append(
            base_path('routes/web.php'),
            "\nRoute::view('dashboard', 'dashboard')\n\t->name('dashboard')\n\t->middleware(['auth', 'verified']);\n"
        );

        $welcomeView = resource_path('views/welcome.blade.php');

        // Update the welcome view to redirect to the dashboard
        File::put(
            $welcomeView,
            Str::replace(
                "{{ url('/home') }}",
                "{{ url('/dashboard') }}",
                File::get($welcomeView)
            )
        );

        $fortifyConfig = config_path('fortify.php');

        // Update the Fortify config to redirect to the dashboard
        File::put(
            $fortifyConfig,
            Str::replace(
                "'home' => '/home',",
                "'home' => '/dashboard',",
                File::get($fortifyConfig)
            )
        );
    }
}
