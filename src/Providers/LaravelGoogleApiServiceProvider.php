<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelGoogleApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishConfig();
    }

    private function publishConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/google.php' => config_path('google.php')
        ], 'laravel-google-api-config');
    }
}
