<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\OpenHolidayApi\CountryRepository;
use App\Repositories\OpenHolidayApi\HolidayRepository;
use App\Repositories\Contracts\CountryRepositoryInterface;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use App\Repositories\Contracts\SubdivisionRepositoryInterface;
use App\Repositories\OpenHolidayApi\SubdivisionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HolidayRepositoryInterface::class, HolidayRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(SubdivisionRepositoryInterface::class, SubdivisionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
