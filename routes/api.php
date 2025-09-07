<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CatchExceptions;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GetCountryListController;
use App\Http\Controllers\GetSubdivisionsController;
use App\Http\Controllers\GetPublicHolidayController;
use App\Http\Controllers\GetSchoolHolidayController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('holidays')
    ->middleware(CatchExceptions::class)
    ->group(function () {
        Route::get('public', GetPublicHolidayController::class)
            ->name('holidays.public');

        Route::get('school', GetSchoolHolidayController::class)
            ->name('holidays.school');
});

Route::controller(StateController::class)
    ->prefix('states')
    ->as('states.')
    ->middleware(CatchExceptions::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{state}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::patch('/{state}', 'update')->name('update');
        Route::delete('/{state}', 'destroy')->name('destroy');
});

Route::controller(CountryController::class)
    ->prefix('countries')
    ->as('countries.')
    ->middleware(CatchExceptions::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{country}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::patch('/{country}', 'update')->name('update');
        Route::delete('/{country}', 'destroy')->name('destroy');
});

Route::controller(GetSubdivisionsController::class)
    ->prefix('subdivisions')
    ->as('subdivisions.')
    ->middleware(CatchExceptions::class)
    ->group(function () {
        Route::get('/', '__invoke')
            ->name('list');
});
