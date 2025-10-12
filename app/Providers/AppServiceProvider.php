<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\Contracts\CountryRepositoryInterface;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Contracts\SubdivisionRepositoryInterface;
use App\Repositories\OpenHolidayApi\CountryRepository;
use App\Repositories\OpenHolidayApi\HolidayRepository;
use App\Repositories\OpenHolidayApi\LanguageRepository;
use App\Repositories\OpenHolidayApi\SubdivisionRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->configureSuperAdminGate();
    }

    /**
     * Configure super admin gate that bypasses all authorization checks.
     */
    protected function configureSuperAdminGate(): void
    {
        Gate::before(function (User $user, string $ability) {
            // If user is an admin, grant all abilities
            if ($user->is_admin) {
                return true;
            }

            // Otherwise, let the policy decide
            return null;
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(100)->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'error' => 'Too many requests. Please try again later.',
                    ], 429);
                });
        });

        RateLimiter::for('holidays', function (Request $request) {
            return Limit::perMinute(200)->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'error' => 'Too many holiday requests. Please try again later.',
                    ], 429);
                });
        });

        RateLimiter::for('metadata', function (Request $request) {
            return Limit::perMinute(300)->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'error' => 'Too many metadata requests. Please try again later.',
                    ], 429);
                });
        });

        RateLimiter::for('strict', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'error' => 'Too many write operations. Please try again later.',
                    ], 429);
                });
        });
    }
}
