<?php
use App\Http\Controllers\Valuers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:web'])->group(function () {
    Route::group(['as' => 'dashboard.'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
    });
});
