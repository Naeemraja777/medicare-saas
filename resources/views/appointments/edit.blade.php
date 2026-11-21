@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('appointments.show', $appointment) }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Details</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Update Appointment & Clinical Notes</h1>
        </div>

        <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Patient *</label>
                    <select name="patient_id" required class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" @selected(old('patient_id', $appointment->patient_id) == $patient->id)>
                                {{ $patient->patient_number }} — {{ $patient->first_name }} {{ $patient->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Doctor *</label>
                    <select name="doctor_id" required class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" @selected(old('doctor_id', $appointment->doctor_id) == $doctor->id)>
                                Dr. {{ $doctor->user->name ?? 'Doctor #' . $doctor->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Date & Time *</label>
                    <input type="datetime-local" name="appointment_date"
                           value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d\TH:i')) }}" required
                           class="w-full rounded-lg text-sm focus:border-blue-600 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status *</label>
                    <select name="status" required class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">
                        @foreach(['scheduled' => 'Scheduled', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'no_show' => 'No Show'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $appointment->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Symptoms Description</label>
                <textarea name="symptoms_descriptions" rows="3"
                          class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">{{ old('symptoms_descriptions', $appointment->symptoms_descriptions) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Doctor Clinical Notes</label>
                <textarea name="doctor_notes" rows="5" placeholder="Diagnosis, observations, follow-up instructions..."
                          class="w-full rounded-lg  text-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('doctor_notes', $appointment->doctor_notes) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('appointments.show', $appointment) }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700">Save Changes</button>
            </div>
        </form>
    </div>
@endsection
