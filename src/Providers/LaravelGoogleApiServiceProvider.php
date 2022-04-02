<?php
declare(strict_types=1);

namespace KielD01\LaravelGoogleApi\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelGoogleApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishConfig();
    }

    private function publishConfig() {

    }
}