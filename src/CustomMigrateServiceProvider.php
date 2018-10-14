<?php

namespace Sayeed\CustomMigrate;

use Illuminate\Support\ServiceProvider;

class CustomMigrateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->loadRoutesFrom(__DIR__. '/routes/web.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \Sayeed\CustomMigrate\Commands\CustomMigrateCommand::class,
        ]);
    }
}
