@extends('layouts.app')

@section('title', $patient->name . ' - ')
@section('header', $patient->name)
@section('subheader', 'Patient ID: ' . $patient->patient_number)

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('patients.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">
            &larr; Back to Patient Directory
        </a>
        <a href="{{ route('patients.edit', $patient) }}"
           class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
            Edit Profile
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Demographics & Medical History --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-6 space-y-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">Patient Details</h2>

                <div>
                    <p class="text-xs text-slate-500">Patient Number</p>
                    <p class="font-mono text-sm font-semibold text-blue-600">{{ $patient->patient_number }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Date of Birth & Age</p>
                    <p class="text-sm font-medium text-slate-900">
                        {{ $patient->date_of_birth->format('M d, Y') }} ({{ $patient->date_of_birth->age }} yrs)
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Gender</p>
                    <p class="text-sm font-medium text-slate-900 capitalize">{{ $patient->gender }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Phone</p>
                    <p class="text-sm font-medium text-slate-900">{{ $patient->phone }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Email</p>
                    <p class="text-sm font-medium text-slate-900">{{ $patient->email ?? 'Not provided' }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-xs p-6">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-3">Medical History</h2>
                <p class="text-sm text-slate-700 whitespace-pre-line">
                    {{ $patient->medical_history ?: 'No medical history recorded.' }}
                </p>
            </div>
        </div>

        {{-- Right Column: Appointment History --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900">Appointment History</h2>
                    <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">
                        {{ $patient->appointments->count() }} Total
                    </span>
                </div>

                <div class="divide-y divide-slate-200">
                    @forelse($patient->appointments as $appointment)
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y - h:i A') }}
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $appointment->notes ?? 'Routine consultation' }}
                                </p>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 capitalize">
                                {{ $appointment->status ?? 'Scheduled' }}
                            </span>
                        </div>
                    @empty
                        <div class="p-8 text-center text-sm text-slate-500">
                            No appointments scheduled for this patient yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

