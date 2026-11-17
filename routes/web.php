<?php
use App\Models\User;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\PatientController;

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
//Route::middleware(['auth'])->get('/home',function(){
//    return 'Login into:'.auth()->user()->tenant->name;
//})->name('home');

Route::middleware(['auth','role:clinic_admin'])->prefix('admin')->group(function(){
    Route::get('/dashboard', function () {
      $stats=[
          'doctors'=>Doctor::count(),
          'patients'=>Patient::count(),
          'appointments'=>Appointment::count(),
          'staff'=>User::count(),

      ];

      $staffMembers=User::with('doctorProfile')->get();
      return view('dashboards.admin',compact('stats','staffMembers'));
    })->name('admin.dashboard');
    Route::resource('patients',PatientController::class)->except('destroy');
    Route::delete('/patients/{patient}',[PatientController::class,'destroy'])->name('patients.destroy');
    Route::post('/staff',[StaffController::class,'store'])->name('add.staff.store');
});
Route::middleware(['auth','role:doctor'])->prefix('doctor')->group(function(){
    Route::get('/appointments', function () {
        $appointments=Appointment::with('patients')->latest('appointment_date')->get();
        return view('dashboards.doctor',compact('appointments'));
    })->name('doctor.appointments');
    Route::resource('patients',PatientController::class)->except('destroy');
});
Route::middleware(['auth','role:receptionist'])->prefix('reception')->group(function(){
    Route::resource('patients',PatientController::class)->except('destroy');
    Route::get('/scheduler', function () {
        $doctors=Doctor::where('status','active')->get();
        $appointments=Appointment::with('patients')->latest('appointment_date')->get();
        return view('dashboards.reception',compact('doctors','appointments'));
    })->name('reception.scheduler');
});


