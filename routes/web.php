<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GeographicalController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminSchoolController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AdminActivityController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard');
        }
        return Inertia::render('Admin/Dashboard', [
            'user' => auth()->user(),
        ]);
    })->name('admin.dashboard');

    // Admin Profile
    Route::get('/admin/profile', function () {
        return Inertia::render('Admin/Profile/Index', [
            'user' => auth()->user(),
        ]);
    })->name('admin.profile');

    // User Dashboard - for school_manager, district_manager, teacher, student
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Only admin goes to admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // All other roles (school_manager, district_manager, teacher, student) use regular dashboard
        return Inertia::render('Dashboard', [
            'user' => $user,
        ]);
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Management Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    // Regions
    Route::get('/regions', [GeographicalController::class, 'regions'])->name('admin.regions');
    Route::post('/regions', [GeographicalController::class, 'storeRegion'])->name('admin.regions.store');
    Route::patch('/regions/{region}', [GeographicalController::class, 'updateRegion'])->name('admin.regions.update');
    Route::delete('/regions/{region}', [GeographicalController::class, 'deleteRegion'])->name('admin.regions.delete');

    // Districts
    Route::get('/districts', [GeographicalController::class, 'districts'])->name('admin.districts');
    Route::post('/districts', [GeographicalController::class, 'storeDistrict'])->name('admin.districts.store');
    Route::patch('/districts/{district}', [GeographicalController::class, 'updateDistrict'])->name('admin.districts.update');
    Route::delete('/districts/{district}', [GeographicalController::class, 'deleteDistrict'])->name('admin.districts.delete');

    // Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('admin.reports.index');

    // Schools
    Route::get('/schools', [AdminSchoolController::class, 'index'])->name('admin.schools.index');
    Route::post('/schools', [AdminSchoolController::class, 'store'])->name('admin.schools.store');
    Route::patch('/schools/{school}', [AdminSchoolController::class, 'update'])->name('admin.schools.update');
    Route::delete('/schools/{school}', [AdminSchoolController::class, 'destroy'])->name('admin.schools.destroy');

    // Settings
    Route::get('/settings/general', [AdminSettingController::class, 'general'])->name('admin.settings.general');
    Route::patch('/settings/general', [AdminSettingController::class, 'updateGeneral'])->name('admin.settings.general.update');
    Route::get('/settings/smtp', [AdminSettingController::class, 'smtp'])->name('admin.settings.smtp');
    Route::patch('/settings/smtp', [AdminSettingController::class, 'updateSmtp'])->name('admin.settings.smtp.update');
    Route::post('/settings/smtp/test', [AdminSettingController::class, 'testSmtp'])->name('admin.settings.smtp.test');
    Route::get('/settings/security', [AdminSettingController::class, 'security'])->name('admin.settings.security');
    Route::get('/settings/health', [AdminSettingController::class, 'health'])->name('admin.settings.health');
    Route::post('/settings/health/clear-cache', [AdminSettingController::class, 'clearCache'])->name('admin.settings.health.clear-cache');

    // Backups
    Route::get('/settings/backup', [BackupController::class, 'index'])->name('admin.settings.backup');
    Route::post('/settings/backup', [BackupController::class, 'store'])->name('admin.settings.backup.store');
    Route::get('/settings/backup/{backup}/download', [BackupController::class, 'download'])->name('admin.settings.backup.download');

    // Activity Logs
    Route::get('/activitylogs', [AdminActivityController::class, 'index'])->name('admin.activitylogs');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::delete('/users', [AdminUserController::class, 'bulkDestroy'])->name('admin.users.bulk-destroy');
});

require __DIR__.'/auth.php';
