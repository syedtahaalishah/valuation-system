<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Valuers\ReportController;
use App\Http\Controllers\Valuers\ProfileController;
use App\Http\Controllers\Valuers\DashboardController;

Route::middleware(['auth:web'])->group(function () {
    Route::group(['as' => 'dashboard.'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
    });
    Route::group(['as' => 'profile.'], function () {
        Route::get('profile', [ProfileController::class, 'index'])->name('index');
        Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::post('profile/picture', action: [ProfileController::class, 'updatePicture'])->name('picture.update');
    });
    Route::resource('reports', ReportController::class);
});
