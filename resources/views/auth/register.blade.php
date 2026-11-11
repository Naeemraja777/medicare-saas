@extends('layouts.guest')

@section('title', 'Launch Clinic Workspace - MediCare SaaS')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Create your clinic workspace</h1>
        <p class="mt-1.5 text-sm text-slate-600">
            Already have a workspace?
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500">Sign in here</a>
        </p>
    </div>
    @if ($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
            <div class="font-semibold mb-1">Please correct the following errors:</div>
            <ul class="list-disc pl-5 space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Section 1: Clinic Details -->
        <div class="rounded-xl bg-slate-50 border border-slate-200/80 p-4 space-y-4">
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">1. Organization Details</div>

            <div>
                <label for="clinic_name" class="block text-sm font-medium text-slate-700">Hospital or Clinic Name</label>
                <input id="clinic_name" type="text" name="clinic_name" value="{{ old('clinic_name') }}" required
                       oninput="document.getElementById('clinic_slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                       class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 shadow-xs focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/20"
                       placeholder="e.g. CityCare General Hospital">
            </div>
            <div>
                <label for="clinic_slug" class="block text-sm font-medium text-slate-700">Dedicated Workspace URL</label>
                <div class="mt-1 flex rounded-lg shadow-xs">
                    <input id="clinic_slug" type="text" name="clinic_slug" value="{{ old('clinic_slug') }}" required
                           class="block w-full rounded-l-lg border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/20"
                           placeholder="citycare-hospital">
                    <span class="inline-flex items-center rounded-r-lg border border-l-0 border-slate-300 bg-slate-100 px-3 text-xs font-medium text-slate-600">
                        .medicare.app
                    </span>
                </div>
            </div>
        </div>
        <!-- Section 2: Admin Account -->
        <div class="space-y-4 pt-1">
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">2. Primary Administrator</div>

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-slate-900 shadow-xs focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/20"
                      >
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Work Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-slate-900 shadow-xs focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/20"
                       >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" type="password" name="password" required
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-slate-900 shadow-xs focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/20"
                          >
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm text-slate-900 shadow-xs focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600/20"
                           >
                </div>
            </div>
        </div>
        <button type="submit"
                class="w-full flex justify-center items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2.5 px-4 rounded-lg text-sm shadow-sm transition cursor-pointer">
            Provision Clinic Workspace
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </form>

@endsection
