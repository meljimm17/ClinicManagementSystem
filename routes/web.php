<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientQueueController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AdminController;

// ── Public Routes ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/', function () { return redirect()->route('login'); });
});

// Public waiting area queue display (for clinic screens)
Route::get('/clinic/queue', [PatientQueueController::class, 'waitingArea'])->name('clinic.queue');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Protected Routes ──
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // ── Admin Group ──
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
        Route::get('/medical-records', [MedicalRecordController::class, 'adminIndex'])->name('medical-records');
        Route::get('/queue', [PatientQueueController::class, 'adminIndex'])->name('queue');
        Route::patch('/queue/{patientQueue}', [PatientQueueController::class, 'update'])->name('queue.update');
        Route::delete('/queue/{patientQueue}', [PatientQueueController::class, 'destroy'])->name('queue.destroy');
        Route::get('/schedule', [AdminController::class, 'schedule'])->name('schedule');
        Route::post('/schedule', [AdminController::class, 'storeSchedule'])->name('schedule.store');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/reports/export', [AdminController::class, 'exportReports'])->name('reports.export');
        Route::get('/administration', [AdminController::class, 'administration'])->name('administration');
        Route::post('/administration/users', [AdminController::class, 'storeUser'])->name('administration.users.store');
        Route::put('/administration/users/{id}', [AdminController::class, 'updateUser'])->name('administration.users.update');
        Route::delete('/administration/users/{id}', [AdminController::class, 'destroyUser'])->name('administration.users.destroy');
        Route::post('/administration/settings', [AdminController::class, 'saveSettings'])->name('administration.settings.save');
    });

    // ── Doctor Group ──
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::get('/patientqueue', [DoctorController::class, 'queue'])->name('queue');
        Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records');
        Route::get('/medical-records/{medicalRecord}/print', [MedicalRecordController::class, 'printDoctorRecord'])->name('medical-records.print');
        Route::post('/record', [DoctorController::class, 'storeRecord'])->name('record.store');
        Route::post('/record/print-prescription', [DoctorController::class, 'printPrescription'])->name('record.print');
        Route::patch('/patientqueue/{patientQueue}/call', [DoctorController::class, 'callPatient'])->name('queue.call');
        Route::patch('/patientqueue/{patientQueue}/complete', [DoctorController::class, 'completePatient'])->name('queue.complete');
    });

    // ── Staff Group ──
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'index'])->name('dashboard');
        Route::post('/dashboard', [PatientController::class, 'store'])->name('store');
        Route::get('/patientqueue', [PatientQueueController::class, 'index'])->name('queue');
        Route::patch('/patientqueue/{patientQueue}', [PatientQueueController::class, 'update'])->name('queue.update');
        Route::delete('/patientqueue/{patientQueue}', [PatientQueueController::class, 'destroy'])->name('queue.destroy');
    });

    // ── Patients (Search fix) ──
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/search', [PatientController::class, 'search'])->name('search');
        Route::get('/{id}', [PatientController::class, 'show'])->name('show');
    });

    // ── Universal Dashboard Redirect ──
    Route::get('/dashboard', function () {
        $role = strtolower(trim(Auth::user()->role));
        return match ($role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'staff'  => redirect()->route('staff.dashboard'),
            default  => redirect()->route('login'),
        };
    })->name('dashboard');
});