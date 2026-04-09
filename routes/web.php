<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

/**
 * 1. Root Logic
 * Redirects users to their specific dashboard based on their role upon visiting the root URL.
 */
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ($user->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'), 
            'staff'  => redirect()->route('staff.dashboard'),
            default  => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

/**
 * 2. Auth Routes
 * Handles login and logout functionality.
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/**
 * 3. Protected Dashboards
 * Routes wrapped in 'auth' middleware to ensure only logged-in users can access them.
 */
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    });

    // Doctor Routes
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', fn () => view('doctor.dashboard'))->name('dashboard'); 
    });

    // Staff Routes
  Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', fn () => view('staff.dashboard'))->name('dashboard');
    // Change 'staff.queue' to 'staff.patientqueue'
    Route::get('/patientqueue', fn () => view('staff.patientqueue'))->name('queue'); // Optional: Keep old route for backward compatibility 
});

    /**
     * Generic Dashboard Redirect
     * Fallback route that directs users to the correct dashboard based on their role string.
     */
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        return match (strtolower(trim($user->role))) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor', 'dr' => redirect()->route('doctor.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => redirect()->route('login'),
        };
    })->name('dashboard');
});