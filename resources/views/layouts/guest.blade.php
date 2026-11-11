<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MediCare SaaS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased text-slate-900">
<div class="min-h-full flex">
    <!-- Left Column: Form Workspace -->
    <div class="flex-1 flex flex-col justify-center py-10 px-4 sm:px-6 lg:flex-none lg:w-1/2 lg:px-16 xl:px-24 bg-white">
        <div class="mx-auto w-full max-w-md">
            <!-- Brand Header -->
            <div class="flex items-center gap-2.5 mb-8">
                <div class="h-10 w-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-tight text-slate-900">MediCare</span>
                    <span class="ml-1.5 inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">CLOUD</span>
                </div>
            </div>

            @yield('content')
        </div>
    </div>
    <!-- Right Column: Enterprise SaaS Showcase (Hidden on mobile, visible on lg+) -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden flex-col justify-between p-12 text-white">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/90 via-slate-900 to-slate-950"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#60a5fa 1px, transparent 1px); background-size: 24px 24px;"></div>

        <!-- Top Security Badge -->
        <div class="relative z-10 flex items-center gap-2 text-xs font-medium text-blue-300 bg-blue-950/60 border border-blue-800/60 rounded-full px-3.5 py-1.5 w-fit">
            <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Multi-Tenant Isolated Infrastructure • HIPAA-Ready Architecture
        </div>
        <!-- Center Value Proposition -->
        <div class="relative z-10 max-w-lg my-auto">
            <h2 class="text-3xl font-bold tracking-tight text-white leading-snug">
                Clinical operations, patient records, and scheduling in one unified workspace.
            </h2>
            <p class="mt-4 text-slate-300 text-base leading-relaxed">
                Designed for modern hospitals and multi-specialty clinics. Every workspace runs with strict tenant-level data isolation, role-based access, and real-time analytics.
            </p>

            <div class="mt-8 grid grid-cols-2 gap-4 border-t border-slate-800 pt-8">
                <div>
                    <p class="text-2xl font-bold text-white">100%</p>
                    <p class="text-xs text-slate-400 mt-1">Tenant Data Isolation</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">99.9%</p>
                    <p class="text-xs text-slate-400 mt-1">Cloud Uptime SLA</p>
                </div>
            </div>
        </div>
        <!-- Footer Note -->
        <div class="relative z-10 text-xs text-slate-400 flex items-center justify-between border-t border-slate-800/80 pt-6">
            <span>&copy; {{ date('Y') }} MediCare Health Systems</span>
            <span>Enterprise Edition v1.0</span>
        </div>
    </div>
</div>
</body>
</html>

