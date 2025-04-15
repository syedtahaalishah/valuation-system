<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Valuers\ProfileController;
use App\Http\Controllers\Valuers\DashboardController;
use App\Http\Controllers\Valuers\ReportController as ValuerReport;

Route::group(['as' => 'web.'], function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::post('verify', [ReportController::class, 'verify'])->name('verify');
    Route::get('report/{report}', [ReportController::class, 'report'])->name('report');
});

Route::middleware(['auth:web'])->group(function () {
    Route::group(['as' => 'dashboard.'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
    });
    Route::group(['as' => 'profile.'], function () {
        Route::get('profile', [ProfileController::class, 'index'])->name('index');
        Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::post('profile/picture', action: [ProfileController::class, 'updatePicture'])->name('picture.update');
        Route::post('profile/password', action: [ProfileController::class, 'updatePassword'])->name('password.update');
    });
    Route::resource('reports', ValuerReport::class);
});
