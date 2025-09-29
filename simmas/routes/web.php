<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DudiController;
use App\Http\Controllers\SchoolSettingController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\JournalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // User Management (Admin)
    Route::resource('users', UserController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // DUDI Management
    Route::resource('dudis', DudiController::class);
    
    // School Settings
    Route::resource('school-settings', SchoolSettingController::class)->only(['index', 'update']);
    
    // Internship Management
    Route::resource('internships', InternshipController::class);
    
    // Journal Management
    Route::resource('journals', JournalController::class);
    Route::post('journals/{journal}/verify', [JournalController::class, 'verify'])->name('journals.verify');
});

require __DIR__.'/auth.php';
