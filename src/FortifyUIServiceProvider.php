<?php

namespace Zacksmash\FortifyUI;

use Illuminate\Support\ServiceProvider;
use Zacksmash\FortifyUI\Commands\FortifyUICommand;

class FortifyUIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views'),
            ], 'fortify-ui-views');

            $this->publishes([
                __DIR__ . '/../app/Providers' => base_path('app/Providers'),
            ], 'fortify-ui-provider');

            $this->commands([
                FortifyUICommand::class,
            ]);
        }
    }
}
