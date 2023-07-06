<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Interfaces
        $models = [
            'Location',
            'UnitType',
        ];

        foreach ($models as $model) {
            $this->app->bind("App\\Repositories\\{$model}RepositoryInterface", "App\\Repositories\\{$model}Repository");
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
