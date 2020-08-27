<?php
declare(strict_types = 1);

namespace NickSmit\LaravelRequestBuilder\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use NickSmit\LaravelRequestBuilder\Commands\GenerateRequests;

/**
 * Class LaravelRequestBuilderServiceProvider
 */
class LaravelRequestBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-request-builder.php', 'laravel-request-builder');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../config/laravel-request-builder.php' => config_path('laravel-request-builder.php'),
            ]
        );

        $this->commands([GenerateRequests::class]);
    }
}
