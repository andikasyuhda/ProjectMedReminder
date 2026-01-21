<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\HistoryController as PatientHistoryController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\MedicineController as AdminMedicineController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\MonitoringController as AdminMonitoringController;
use App\Http\Controllers\Admin\EmailController as AdminEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Patient Routes
Route::prefix('patient')->name('patient.')->middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
    Route::post('/compliance/{log}/taken', [PatientDashboardController::class, 'markAsTaken'])->name('compliance.taken');
    Route::get('/history', [PatientHistoryController::class, 'index'])->name('history');
    Route::get('/profile', [PatientProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [PatientProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [PatientProfileController::class, 'updatePassword'])->name('profile.password');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Patients Management
    Route::resource('patients', AdminPatientController::class);
    
    // Medicines Management
    Route::resource('medicines', AdminMedicineController::class);
    
    // Schedules Management
    Route::resource('schedules', AdminScheduleController::class);
    
    // Monitoring
    Route::get('/monitoring', [AdminMonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/{patient}', [AdminMonitoringController::class, 'show'])->name('monitoring.show');

    // Email Management
    Route::get('/emails/create', [AdminEmailController::class, 'create'])->name('emails.create');
    Route::post('/emails/send', [AdminEmailController::class, 'send'])->name('emails.send');
});
