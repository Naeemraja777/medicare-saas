<?php

use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        User::ROLE_ADMIN        => redirect()->route('admin.dashboard'),
        User::ROLE_DOCTOR       => redirect()->route('doctor.appointments'),
        User::ROLE_RECEPTIONIST => redirect()->route('reception.scheduler'),
        default                 => redirect()->route('home'),
    };
});

// 1. Appointment Booking: ONLY Clinic Admin & Receptionist
Route::middleware(['auth', 'role:clinic_admin,receptionist'])->group(function () {
    Route::resource('appointments',AppointmentController::class)->only(['store','create']);

});

// 2. Shared Resources (Admin, Doctor, Receptionist)
Route::middleware(['auth', 'role:clinic_admin,doctor,receptionist'])->group(function () {
    Route::resource('appointments', AppointmentController::class)->except(['create', 'store']);
    Route::patch('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
        ->name('appointments.update-status');

    Route::resource('patients', PatientController::class)->except('destroy');
});

// 3. Clinic Admin ONLY
Route::middleware(['auth', 'role:clinic_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'doctors'      => Doctor::count(),
            'patients'     => Patient::count(),
            'appointments' => Appointment::count(),
            'staff'        => User::count(),
        ];

        $staffMembers = User::with('doctorProfile')->get();
        return view('dashboards.admin', compact('stats', 'staffMembers'));
    })->name('admin.dashboard');

    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::post('/staff', [StaffController::class, 'store'])->name('add.staff.store');
});

// 4. Doctor ONLY (Strictly filtered to logged-in doctor's profile)
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->group(function () {
    Route::get('/appointments', function () {
        $doctorId = auth()->user()->doctorProfile?->id ?? 0;

        $appointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->latest('appointment_date')
            ->get();

        return view('dashboards.doctor', compact('appointments'));
    })->name('doctor.appointments');
});

// 5. Receptionist ONLY
Route::middleware(['auth', 'role:receptionist'])->prefix('reception')->group(function () {
    Route::get('/scheduler', function () {
        $doctors = Doctor::with('user')->where('status', 'active')->get();
        $appointments = Appointment::with(['patient', 'doctor.user'])
            ->latest('appointment_date')
            ->get();

        return view('dashboards.reception', compact('doctors', 'appointments'));
    })->name('reception.scheduler');
});

