@extends('layouts.app')
@section('title','Reception Scheduler')
@section('header','Front-desk Appointment Scheduler')
@section('subheader','Manage patient check-ins and doctor bookings for.'.auth()->user()->tenant->name)
@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
            <h2 class="text-base font-bold text-slate-900 mb-1">Book New Appointment</h2>
            <p class="text-xs  text-slate-500 mb-4">Assign a patient to avaliable doctor</p>
            <div class="rounded-lg bg-slate-50 border border-dashed border-slate-300 p-4 text-xs text-slate-600">
               Booking from controller will contact here in the next step Avaliable doctor in clinic:<strong>{{$doctors->count()}}</strong>
            </div>

        </div>
{{--        Daily Schedule Feed--}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
           <div class="px-6 py-4 border-b border-slate-200">
               <h2 class="text-base font-bold text-slate-900">Clinic Appointment Feed</h2>
           </div>
        </div>
        @if($appointments->isEmpty())
            <div class="p-10 text-center">
                <p class="text-sm font-medium text-slate-700">No appointments on the schedules today</p>
                <p class="text-xs text-slate-500 mt-1">Use the booking panel to register and schedule incoming patients.</p>
            </div>
        @else
                    <div class="divide-y divide-slate-200">
                    @foreach($appointments as $appointment)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <p class="text-sm font-semibold text-slate-900">{{$appointment->patient->name ??'Patient'}}</p>
                            <p class="text-xs  text-slate-500">Scheduled:{{$appointment->appointment_date}}</p>
                        </div>
                            <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emarald-700">
                                {{ucfirst($appointment->status)}}
                           </span>


                    @endforeach

            </div>
        @endif
    </div>
@endsection

