<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\OpenHolidayApi\HolidayRepository;
use App\Repositories\Contracts\HolidayRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HolidayRepositoryInterface::class, HolidayRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
