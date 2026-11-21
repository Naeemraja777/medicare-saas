@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('appointments.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Back to Appointments</a>
                <h1 class="text-2xl font-bold text-slate-900 mt-1">Appointment Details</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('appointments.edit', $appointment) }}" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800">
                    Edit / Add Notes
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-b border-slate-100 pb-6">
                <div>
                    <span class="text-xs uppercase font-semibold text-slate-400">Patient</span>
                    <p class="text-xs text-slate-500">{{ $appointment->patient->name }}</p>
                    <p class="text-xs text-slate-500">{{ $appointment->patient->patient_number }}</p>
                </div>
                <div>
                    <span class="text-xs uppercase font-semibold text-slate-400">Doctor</span>
                    <p class="text-base font-semibold text-slate-900 mt-1"> {{ $appointment->doctor->user->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-xs uppercase font-semibold text-slate-400">Date & Status</span>
                    <p class="text-sm font-medium text-slate-900 mt-1">{{ $appointment->appointment_date->format('M d, Y h:i A') }}</p>
                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $appointment->status_badge }}">
                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                </span>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-800 mb-2">Symptoms Description</h3>
                <div class="p-4 bg-slate-50 rounded-lg text-sm text-slate-700 whitespace-pre-line">
                    {{ $appointment->symptoms_descriptions ?: 'No symptoms recorded.' }}
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-800 mb-2">Doctor Notes</h3>
                <div class="p-4 bg-emerald-50/60 border border-emerald-100 rounded-lg text-sm text-slate-800 whitespace-pre-line">
                    {{ $appointment->doctor_notes ?: 'No clinical notes added yet.' }}
                </div>
            </div>
        </div>
    </div>
@endsection
