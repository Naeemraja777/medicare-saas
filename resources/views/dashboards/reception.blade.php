@extends('layouts.app')

@section('title', 'Reception Scheduler')
@section('header', 'Front-desk Appointment Scheduler')
@section('subheader', 'Manage patient check-ins and doctor bookings for ' . auth()->user()->tenant->name)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Panel: Quick Booking Actions --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900 mb-1">Book New Appointment</h2>
                <p class="text-xs text-slate-500 mb-4">Assign a patient to an available doctor</p>

                <div class="rounded-lg bg-slate-50 border border-dashed border-slate-300 p-4 text-xs text-slate-600 mb-5">
                    Available doctors in clinic: <strong>{{ $doctors->count() }}</strong>
                </div>
            </div>

            <div class="space-y-2.5">
                <a href="{{ route('appointments.create') }}"
                   class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    + Schedule Appointment
                </a>

                <a href="{{ route('appointments.index') }}"
                   class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-lg transition">
                    View All Appointments
                </a>
            </div>
        </div>

        {{-- Right Panel: Daily Schedule Feed --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900">Clinic Appointment Feed</h2>
                <a href="{{ route('appointments.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                    Manage All &rarr;
                </a>
            </div>

            @if($appointments->isEmpty())
                <div class="p-10 text-center">
                    <p class="text-sm font-medium text-slate-700">No appointments on the schedule today</p>
                    <p class="text-xs text-slate-500 mt-1">Use the booking panel to register and schedule incoming patients.</p>
                </div>
            @else
                <div class="divide-y divide-slate-200">
                    @foreach($appointments as $appointment)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $appointment->patient->name ?? 'Patient' }}
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Scheduled: {{ $appointment->appointment_date->format('M d, Y h:i A') }}
                                    @if($appointment->doctor?->user)
                                        &bull; Dr. {{ $appointment->doctor->user->name }}
                                    @endif
                                </p>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                </span>
                                <a href="{{ route('appointments.show', $appointment) }}"
                                   class="text-xs font-medium text-blue-600 hover:text-blue-800">
                                    Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

