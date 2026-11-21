@extends('layouts.app')
@php
    use App\Models\Doctor;
    use App\Models\Patient;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;

    /** @var Collection<int, Patient> $patients */
    /** @var Collection<int, Doctor> $doctors */
    /** @var User $currentUser */
    $currentUser = auth()->user();
@endphp
@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('appointments.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Appointments</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Book New Appointment</h1>
        </div>

        <form method="POST" action="{{ route('appointments.store') }}" class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Patient *</label>
                <select name="patient_id" required class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">
                    <option value="">-- Select Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" @selected(old('patient_id', $selectedPatientId) == $patient->id)>
                            {{ $patient->patient_number }} — {{ $patient->first_name }} {{ $patient->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Doctor *</label>
                <select name="doctor_id" required class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">
                    <option value="">-- Select Doctor --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>
                            Dr. {{ $doctor->user->name ?? 'Doctor #' . $doctor->id }} {{ $doctor->specialization ? '(' . $doctor->specialization . ')' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Appointment Date & Time *</label>
                <input type="datetime-local" name="appointment_date" value="{{ old('appointment_date') }}" required
                       class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">
                @error('appointment_date') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Symptoms / Reason for Visit</label>
                <textarea name="symptoms_descriptions" rows="4" placeholder="Describe patient symptoms or consultation purpose..."
                          class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">{{ old('symptoms_descriptions') }}</textarea>
                @error('symptoms_descriptions') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Schedule Appointment</button>
            </div>
        </form>
    </div>
@endsection
