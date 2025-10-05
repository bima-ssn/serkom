<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DudiController;
use App\Http\Controllers\SchoolSettingController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\JournalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // User Management (Admin)
    Route::resource('users', UserController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // DUDI Management
    Route::resource('dudis', DudiController::class);
    Route::post('dudis/{id}/restore', [DudiController::class, 'restore'])->name('dudis.restore');
    Route::post('dudis/{dudi}/apply', [DudiController::class, 'apply'])->name('dudis.apply');
    
    // School Settings
    Route::resource('school-settings', SchoolSettingController::class)->only(['index', 'update']);
    
    // Internship Management
    Route::resource('internships', InternshipController::class);
    
    // Journal Management
    Route::resource('journals', JournalController::class);
    Route::post('journals/{journal}/verify', [JournalController::class, 'verify'])->name('journals.verify');

    // Users Management (Admin only - controller already enforces role)
});

require __DIR__.'/auth.php';
