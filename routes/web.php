<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Valuers\ProfileController;
use App\Http\Controllers\Valuers\DashboardController;
use App\Http\Controllers\Valuers\ReportController as ValuerReport;

use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Admin\ValuerController as AdminValuer;
use App\Http\Controllers\Admin\ProfileController as AdminProfile;
use App\Http\Controllers\Admin\ActivityController as AdminActivity;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;


use App\Http\Middleware\AdminMiddleware;

Route::group(['as' => 'web.'], function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::post('verify', [ReportController::class, 'verify'])->name('verify');
    Route::get('report/{report}', [ReportController::class, 'report'])->name('report');
});

Route::middleware(['auth:web', AdminMiddleware::class])->group(function () {
    Route::group(['as' => 'dashboard.'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
    });
    Route::group(['as' => 'profile.'], function () {
        Route::get('profile', [ProfileController::class, 'index'])->name('index');
        Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::post('profile/password', action: [ProfileController::class, 'updatePassword'])->name('password.update');
    });
    Route::resource('reports', ValuerReport::class);
});

// Admin
Route::middleware(['auth:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::group(['as' => 'dashboard.'], function () {
        Route::get('dashboard', [AdminDashboard::class, 'index'])->name('index');
    });
    Route::group(['as' => 'profile.'], function () {
        Route::get('profile', [AdminProfile::class, 'index'])->name('index');
        Route::post('profile/update', [AdminProfile::class, 'updateProfile'])->name('update');
        Route::post('profile/password', action: [AdminProfile::class, 'updatePassword'])->name('password.update');
    });
    Route::group(['as' => 'activities.'], function () {
        Route::get('activities', [AdminActivity::class, 'index'])->name('index');
    });

    Route::resource('reports', AdminReport::class)->only(['index', 'show', 'destroy']);
    Route::resource('valuers', AdminValuer::class)->only(['index', 'show', 'destroy']);
    Route::post('valuers/status', [AdminValuer::class, 'valuerStatus'])->name('valuers.status');
});
