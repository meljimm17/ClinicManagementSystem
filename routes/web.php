<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientQueueController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;

// ── 1. Root redirect based on role ──────────────────────────────────────────
Route::get('/', function () {
    if (Auth::check()) {
        return match (strtolower(trim(Auth::user()->role))) {
            'admin'  => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'staff'  => redirect()->route('staff.dashboard'),
            default  => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

// ── 2. Auth Routes ───────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── 3. Protected Routes ──────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // ── Admin ────────────────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
        Route::get('/patientqueue', fn () => view('admin.patientqueue'))->name('queue');
        Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records');
    });

    // ── Doctor ───────────────────────────────────────────────────────────────
    Route::prefix('doctor')->name('doctor.')->group(function () {
        // Dashboard — loads queue filtered by doctor's assigned room
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');

        // Start consultation — marks queue entry as "diagnosing"
        Route::patch('/queue/{patientQueue}/start', [DoctorController::class, 'startConsultation'])->name('queue.start');

        // Save medical record + mark queue as done
        Route::post('/record', [DoctorController::class, 'storeRecord'])->name('record.store');

        Route::get('/patientqueue', [DoctorController::class, 'queue'])->name('queue'); 
        Route::patch('/queue/{patientQueue}/call', [DoctorController::class, 'callPatient'])->name('queue.call');
Route::patch('/queue/{patientQueue}/complete', [DoctorController::class, 'completePatient'])->name('queue.complete');
    });

    // ── Staff ────────────────────────────────────────────────────────────────
    Route::prefix('staff')->name('staff.')->group(function () {
        // Dashboard — shows registration form + recent entries
        Route::get('/dashboard', [PatientController::class, 'index'])->name('dashboard');

        // Submit registration form → saves patient + adds to queue
        Route::post('/dashboard', [PatientController::class, 'store'])->name('store');

        // Patient queue page
        Route::get('/patientqueue', [PatientQueueController::class, 'index'])->name('queue');

        // Update queue entry (status, room, symptoms)
        Route::patch('/patientqueue/{patientQueue}', [PatientQueueController::class, 'update'])->name('queue.update');

        // Remove a patient from the queue
        Route::delete('/patientqueue/{patientQueue}', [PatientQueueController::class, 'destroy'])->name('queue.destroy');
    });

    // ── Patients ─────────────────────────────────────────────────────────────
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/search', [PatientController::class, 'search'])->name('search'); // must be before /{id}
        Route::get('/', [PatientController::class, 'index'])->name('index');
        Route::get('/{id}', [PatientController::class, 'show'])->name('show');
    });

    // ── Generic dashboard redirect ────────────────────────────────────────────
    Route::get('/dashboard', function () {
        return match (strtolower(trim(Auth::user()->role))) {
            'admin'  => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'staff'  => redirect()->route('staff.dashboard'),
            default  => redirect()->route('login'),
        };
    })->name('dashboard');

});