<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Tambahkan use untuk interface dan implementasi repository
use App\Repositories\AcademicInnovationRepositoryInterface;
use App\Repositories\EloquentAcademicInnovationRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind interface ke implementasi agar bisa di-resolve otomatis di controller
        $this->app->bind(
            AcademicInnovationRepositoryInterface::class,
            EloquentAcademicInnovationRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
