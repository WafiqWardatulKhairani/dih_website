<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

// app/Providers/RouteServiceProvider.php
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Path default setelah login.
     */
    public const HOME = '/dashboard'; // ganti sementara, tapi kita akan handle per role

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }
}

