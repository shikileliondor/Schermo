<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolAdminController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'super-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

        Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
        Route::get('/schools/create', [SchoolController::class, 'create'])->name('schools.create');
        Route::post('/schools', [SchoolController::class, 'store'])->name('schools.store');
        Route::get('/schools/{school}', [SchoolController::class, 'show'])->name('schools.show');
        Route::patch('/schools/{school}/toggle', [SchoolController::class, 'toggleStatus'])->name('schools.toggle');
        Route::delete('/schools/{school}', [SchoolController::class, 'destroy'])->name('schools.destroy');
        Route::post('/schools/{school}/migrations', [SchoolController::class, 'runMigrations'])->name('schools.migrations');
        Route::post('/schools/{school}/seeders', [SchoolController::class, 'runSeeders'])->name('schools.seeders');

        Route::get('/school-admins', [SchoolAdminController::class, 'index'])->name('school-admins.index');
        Route::get('/school-admins/create', [SchoolAdminController::class, 'create'])->name('school-admins.create');
        Route::post('/school-admins', [SchoolAdminController::class, 'store'])->name('school-admins.store');
        Route::patch('/school-admins/{admin}/toggle', [SchoolAdminController::class, 'toggleStatus'])->name('school-admins.toggle');
        Route::post('/school-admins/{admin}/reset-password', [SchoolAdminController::class, 'resetPassword'])->name('school-admins.reset');
    });

require __DIR__.'/auth.php';
