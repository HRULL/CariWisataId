<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public static string $HOME = '/redirect';  // <-- Ubah di sini

    public function boot(): void
    {
        $this->routes(function () {
            // route definisi di sini
        });
    }
}

