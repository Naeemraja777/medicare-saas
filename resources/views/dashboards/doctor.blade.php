@extends('layouts.app')
@section('title','Doctor Appointments')
@section('header','Patient Consultation Queue')
@section('subheader','Welcome Back Dr.'.auth()->user()->name)
@section('content')

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900">Schedule Consultations</h2>
                <span class="text-xs font-medium text-slate-500">{{$appointments->count()}}total</span>
            </div>
            @if($appointments->isEmpty())
                <div class="p-10 text-center">
                    <p class="text-sm font-medium text-slate-700">No appointments assigned yet</p>
                    <p class="text-xs text-slate-500 mt-1">Appointments scheduled by reception will be avaliable here.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                         <tr>
                             <th class="px-6 py-3">Date & Time</th>
                             <th class="px-6 py-3">Patients</th>
                             <th class="px-6 py-3">Symptoms</th>
                             <th class="px-6 py-3">Status</th>
                         </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                        @foreach($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{$appointment->appointment_date}}</td>
                                <td class="px-6 py-4">{{$appointment->patient->name??'N/A'}}</td>
                                <td class="px-6 py-4 text-slate-600">{{$appointment->symptoms_description??'General Checkup'}}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700">{{ucfirst($appointments->status)}}total</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
@endsection
