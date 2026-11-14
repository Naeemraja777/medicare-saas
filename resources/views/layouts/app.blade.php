<!doctype html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8" >
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','Workspace'){{auth()->user()->tenant->name}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased text-slate-900">
<div class="min-h-full flex flex-col lg:flex-row">
    <aside class="w-full lg:w-64 bg-slate-900 text-white flex flex-col justify-between shrink-0">
        <div>
            <div class="p-5 border-b border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="h-9 w-9 rounded-lg bg-blue-600 flex items-center justify-center font-bold text-white shadow-xs">M+

                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-black truncate">{{auth()->user()->tenant->name}}</p>
                        <p class="text-xs text-slate-400 truncate">{{auth()->user()->tenant->slug}}</p>
                    </div>
                </div>
            </div>
           {{--Role awareness navigation menu--}}
            <nav class="p-4 space-y-1.5">
                <div class="px-3 py-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">

                </div>
                @if(auth()->user()->isAdmin())
                    <a href="{{route('admin.dashboard')}}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{request()->routeIs('admin.dashboard') ?'bg-blue-600 text-white':'text-slate-300  hover:bg-slate-800 hover:text-white'}}"></a>
                    <span>
                        Clinic Overview
                   </span>
                @endif
                        @if(auth()->user()->isDoctor())
                            <a href="{{route('doctor.appointments')}}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{request()->routeIs('doctor.appointments') ?'bg-blue-600 text-white':'text-slate-300  hover:bg-slate-800 hover:text-white'}}"></a>
                          <span>
                            My Patient Queue
                          </span>
                         @endif
                                @if(auth()->user()->isReceptionist())
                                    <a href="{{route('reception.scheduler')}}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{request()->routeIs('doctor.appointments') ?'bg-blue-600 text-white':'text-slate-300  hover:bg-slate-800 hover:text-white'}}">
                                  <span>
                                     Appointment Scheduler
                                  </span>
                                @endif
            </nav>
        </div>
     {{--User Profiles & Sign Out  --}}
        <div class="p-4 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-medium truncate">{{auth()->user()->name}}</p>
                    <span class="inline-flex items-center rounded bg-slate-800 px-2 py-0.5 text-[11px] font-medium text-blue-300 uppercase">
                           {{str_replace('_','',auth()->user()->role)}}
                    </span>
                </div>
                <form method="POST" action="{{route('logout')}}">
                    @csrf
                    <button type="submit" class="rounded-lg bg-slate-800 hover:bg-red-600 px-2.5 py-1.5 text-xs font-medium text-slate-200 hover:text-white transition cursor-pointer">Logout</button>
                </form>
            </div>
        </div>
    </aside>
{{--    Main Workspace Content--}}
    <div class=" flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg sm:text-xl font-bold text-slate-900">
                    @yield('header')
                </h1>
                <p class="text-xs text-slate-900">
                    @yield('subheader')
                </p>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 border border-emarald-200">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-50"></span>
                                Tenant Isolated

            </span>
        </header>
        <main class="flex-1 p-6 max-w-7xl w-full mx-auto">@yield('content')
        </main>

    </div>
</div>
</body>
</html>
