@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Appointments</h1>
                <p class="text-sm text-slate-500">Manage clinic schedules, patient visits, and consultation statuses.</p>
            </div>
            @if(in_array(auth()->user()->role, ['clinic_admin', 'receptionist']))
                <a href="{{ route('appointments.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                    + Book Appointment
                </a>
            @endif
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('appointments.index') }}" class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Filter by Date</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Filter by Status</label>
                <select name="status" class="w-full rounded-lg  text-sm focus:border-blue-600 focus:ring-blue-600">
                    <option value="">All Statuses</option>
                    @foreach(['scheduled' => 'Scheduled', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'no_show' => 'No Show'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800">
                    Filter
                </button>
                <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200">
                    Reset
                </a>
            </div>
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">Date & Time</th>
                        <th class="px-6 py-3 text-left">Patient</th>
                        <th class="px-6 py-3 text-left">Doctor</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">
                                {{ $appointment->appointment_date->format('M d, Y') }}
                                <span class="block text-xs text-slate-500">{{ $appointment->appointment_date->format('h:i A') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $appointment->patient->name }}</div>
                                <div class="text-xs text-slate-500">{{ $appointment->patient->patient_number }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                Dr. {{ $appointment->doctor->user->name ?? 'Assigned Doctor' }}
                                @if(!empty($appointment->doctor->specialization))
                                    <span class="block text-xs text-slate-500">{{ $appointment->doctor->specialization }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $appointment->status_badge }}">
                                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                <div class="inline-flex items-center justify-end gap-3">
                                <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                <a href="{{ route('appointments.edit', $appointment) }}" class="text-slate-600 hover:text-slate-900 font-medium">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                No appointments found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
@endsection
