<?php

use App\Http\Controllers\StateController;
use App\Http\Middleware\CatchExceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
