<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

// 1. Root Logic
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match (strtolower(trim($user->role))) {
            'admin'  => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'), 
            'staff'  => redirect()->route('staff.dashboard'),
            default  => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

// 2. Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// 3. Protected Dashboards
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
        Route::get('/patientqueue', fn () => view('admin.patientqueue'))->name('queue'); 
        Route::get('/medical-records', fn () => view('admin.medical-records'))->name('medical-records'); 
    });

    // Doctor Routes
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', fn () => view('doctor.dashboard'))->name('dashboard'); 
    });

    // Staff Routes
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', fn () => view('staff.dashboard'))->name('dashboard');
        Route::get('/patientqueue', fn () => view('staff.patientqueue'))->name('queue'); 
    });

    // Generic Dashboard Named Route
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return match (strtolower(trim($user->role))) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor', 'dr' => redirect()->route('doctor.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => redirect()->route('login'),
        };
    })->name('dashboard');
});