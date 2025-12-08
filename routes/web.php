<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GeographicalController;
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

// Admin Geographical Management Routes
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
});

require __DIR__.'/auth.php';
