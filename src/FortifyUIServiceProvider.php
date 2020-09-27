<?php

namespace Zacksmash\FortifyUI;

use Illuminate\Support\ServiceProvider;
use Zacksmash\FortifyUI\Commands\FortifyUICommand;

class FortifyUIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__ . '/../config/fortify-ui.php' => config_path('fortify-ui.php'),
            // ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views'),
            ], 'views');

            $this->publishes([
                __DIR__ . '/../app/Providers' => base_path('app/Providers'),
            ], 'provider');

            // $migrationFileName = 'create_fortify_ui_table.php';
            // if (! $this->migrationFileExists($migrationFileName)) {
            //     $this->publishes([
            //         __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
            //     ], 'migrations');
            // }

            $this->commands([
                FortifyUICommand::class,
            ]);
        }

        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'fortify-ui');
    }

    public function register()
    {
        // $this->mergeConfigFrom(__DIR__ . '/../config/fortify-ui.php', 'fortify-ui');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
