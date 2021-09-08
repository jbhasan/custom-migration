<?php

namespace Sayeed\CustomMigrate;

use Illuminate\Support\ServiceProvider;
use Sayeed\CustomMigrate\Console\Commands\CustomMigrateCommand;

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
            CustomMigrateCommand::class,
        ]);
    }
}
