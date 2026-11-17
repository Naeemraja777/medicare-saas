@extends('layouts.app')

@section('title', 'Edit Patient - ')
@section('header', 'Edit Patient Record')
@section('subheader', 'Updating profile for ' . $patient->name . ' (' . $patient->patient_number . ')')

@section('content')
    <div class="max-w-3xl bg-white rounded-xl border border-slate-200 shadow-xs p-6">
        <form method="POST" action="{{ route('patients.update', $patient) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $patient->name) }}" required
                       class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-xs focus:border-blue-500 focus:ring-blue-500">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth->format('Y-m-d')) }}" required
                           class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-xs focus:border-blue-500 focus:ring-blue-500">
                    @error('date_of_birth') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" required
                            class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-xs focus:border-blue-500 focus:ring-blue-500">
                        <option value="male" @selected(old('gender', $patient->gender) === 'male')>Male</option>
                        <option value="female" @selected(old('gender', $patient->gender) === 'female')>Female</option>
                        <option value="both" @selected(old('gender', $patient->gender) === 'both')>Both / Other</option>
                    </select>
                    @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" required
                           class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-xs focus:border-blue-500 focus:ring-blue-500">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $patient->email) }}"
                           class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-xs focus:border-blue-500 focus:ring-blue-500">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Medical History & Notes</label>
                <textarea name="medical_history" rows="4"
                          class="mt-1 block w-full rounded-lg border-slate-300 text-sm shadow-xs focus:border-blue-500 focus:ring-blue-500">{{ old('medical_history', $patient->medical_history) }}</textarea>
                @error('medical_history') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('patients.index') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 cursor-pointer">
                    Update Patient Record
                </button>
            </div>
        </form>
    </div>
@endsection

