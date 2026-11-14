@extends('layouts.app')
@section('title','Admin Dashboard')
@section('header','Clinic Management Overview')
@section('subheader','Real-time operational metrics for'.auth()->user()->tenant->name)
@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <p class="text-xs font-medium text-slate-500 uppercase">Active Doctors</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{$stats['patients']}}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <p class="text-xs font-medium text-slate-500 uppercase">Total Appointments</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{$stats['appointments']}}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <p class="text-xs font-medium text-slate-500 uppercase">Clinic Staff Users</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{$stats['staff']}}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
        <h2 class="text-base font-bold text-slate-900 mb-2">Workspace Configuration</h2>
        <p class="text-sm text-slate-600">Your clinic data is strictly isolated under tenant ID<span class="font-mono font-semibold text-slate-800">#{{auth()->user()->tenant_id}}</span></p>
    </div>
@endsection
