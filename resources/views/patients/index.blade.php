@extends('layouts.app')
@section('title', 'Patients - ')
@section('header', 'Patient Directory')
@section('subheader', 'Manage clinic patient records and medical histories')
@section('content')
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <form method="GET" action="{{ route('patients.index') }}" class="flex-1 flex gap-2 max-w-lg">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by Patient #, Name, Phone, or Email..."
                   class="w-full rounded-lg border-slate-300 text-sm shadow-xs focus:border-blue-500 focus:ring-blue-500">
            <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800 cursor-pointer">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('patients.index') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>
        <a href="{{ route('patients.create') }}"
           class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-700">
            + Register Patient
        </a>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Patient #</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Full Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">DOB & Gender</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Contact</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($patients as $patient)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-semibold text-blue-600">
                            {{ $patient->patient_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">
                            {{ $patient->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            {{ $patient->date_of_birth->format('M d, Y') }}
                            <span class="ml-1 inline-flex items-center rounded bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700 capitalize">
                                    {{ $patient->gender }}
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                            <div>{{ $patient->phone }}</div>
                            @if($patient->email)
                                <div class="text-xs text-slate-400">{{ $patient->email }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="inline-flex items-center justify-end gap-3">
                                <a href="{{ route('patients.show', $patient) }}" class="text-blue-600 hover:text-blue-800">
                                    View
                                </a>
                                <a href="{{ route('patients.edit', $patient) }}" class="text-slate-600 hover:text-slate-900">
                                    Edit
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="m-0 p-0 inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 cursor-pointer"
                                                onclick="return confirm('Delete this patient record permanently?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                            No patient records found. Click <strong>+ Register Patient</strong> to add your first patient.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($patients->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $patients->links() }}
            </div>
        @endif
    </div>
@endsection
