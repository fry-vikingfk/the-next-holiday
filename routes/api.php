<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\GetLanguagesController;
use App\Http\Controllers\GetPublicHolidayController;
use App\Http\Controllers\GetSchoolHolidayController;
use App\Http\Controllers\GetSubdivisionsController;
use App\Http\Controllers\StateController;
use App\Http\Middleware\CatchExceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('holidays')
    ->middleware([CatchExceptions::class, 'throttle:holidays'])
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
        Route::get('/', 'index')->name('index')->middleware('throttle:metadata');
        Route::get('/{state}', 'show')->name('show')->middleware('throttle:metadata');
        Route::post('/', 'store')->name('store')->middleware('throttle:strict');
        Route::patch('/{state}', 'update')->name('update')->middleware('throttle:strict');
        Route::delete('/{state}', 'destroy')->name('destroy')->middleware('throttle:strict');
    });

Route::controller(CountryController::class)
    ->prefix('countries')
    ->as('countries.')
    ->middleware(CatchExceptions::class)
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('throttle:metadata');
        Route::get('/{country}', 'show')->name('show')->middleware('throttle:metadata');
        Route::post('/', 'store')->name('store')->middleware('throttle:strict');
        Route::patch('/{country}', 'update')->name('update')->middleware('throttle:strict');
        Route::delete('/{country}', 'destroy')->name('destroy')->middleware('throttle:strict');
    });

Route::controller(GetSubdivisionsController::class)
    ->prefix('subdivisions')
    ->as('subdivisions.')
    ->middleware([CatchExceptions::class, 'throttle:metadata'])
    ->group(function () {
        Route::get('/', '__invoke')
            ->name('list');
    });

Route::controller(GetLanguagesController::class)
    ->prefix('languages')
    ->as('languages.')
    ->middleware([CatchExceptions::class, 'throttle:metadata'])
    ->group(function () {
        Route::get('/', '__invoke')
            ->name('list');
    });
