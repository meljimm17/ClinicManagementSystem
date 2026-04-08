<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

// 1. Root Logic
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

// 2. Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// 3. Protected Dashboards (The NAMES are critical here)
Route::middleware(['auth'])->group(function () {
    
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    });

    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', fn () => view('doctor.dashboard'))->name('dashboard'); // This creates 'doctor.dashboard'
    });

    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', fn () => view('staff.dashboard'))->name('dashboard');
    });

    // Generic dashboard route used by shared nav or fallback logic
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