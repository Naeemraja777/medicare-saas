@extends('layouts.app')
@section('title','Admin Dashboard')
@section('header','Clinic Management Overview')
@section('subheader','Real-time operational metrics for'.auth()->user()->tenant->name)
@section('content')
    @if(session('status'))
        <div class="mb-6 rounded-xl bg-emarald-50 border border-emarald-200 px-4 py-3 text-sm font-medium text-emerald-800">
            {{session('status')}}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 p-4 text-sm  text-red-700">
            <ul class="list-disc pl-5 space-y-1 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>

        </div>
    @endif
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
            <h2 class="text-base font-bold text-slate-900 mb-1">Onboard Clinical Staff</h2>
            <p class="text-xs text-slate-500 mb-5">Create  login credentials for a Doctor of Patient</p>
            <form method="POST" action="{{route('add.staff.store')}}" class="space-y-4">
              @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600">Role</label>
                    <select name="role" id="staff_role" onchange="document.getElementById('doctor_fields').style.display=this.value==='doctor'?'block':'none'"
                    class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm  focus:outline-none">
                        <option value="doctor" {{old('role','doctor')==='doctor' ? 'selected':''}}>Doctor</option>
                        <option value="receptionist" {{ old('role') === 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600">Full Name</label>
                       <input type="text" name="name" value="{{old('name')}}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm  focus:outline-none" placeholder="Dr Ayesha Tariq">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600">Work Email</label>
                    <input type="text" name="email" value="{{old('email')}}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm  focus:outline-none" placeholder="ayesha@clinic.com">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600">Temporay Password</label>
                    <input type="password" name="password" value="{{old('password')}}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm  focus:outline-none" placeholder="Min.8 Characters">
                </div>
                <div id="doctor_fields" class="space-y-4 pt-2 border-t border-slate-100" @style(['diplay:none'=>old('role','doctor')!=='doctor'])>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600">Specialization</label>
                        <input type="text" name="specialization" value="{{old('specialization')}}"  class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm  focus:outline-none" placeholder="Cardiology/General Medicine">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600">Medical License</label>
                        <input type="text" name="license_number" value="{{old('license_number')}}"  class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm  focus:outline-none" placeholder="PMC-98421">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-600">Contact Phone</label>
                        <input type="text" name="phone" value="{{old('phone')}}"  class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm  focus:outline-none" placeholder="+923001234567">
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg text-sm transition cursor-pointer">Create Staff Account</button>
            </form>
        </div>
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200  shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border border-slate-200 flex items-center justify-between">
                <h2 class="text-base font-bold text-slate-900">Active Workspace  Staff</h2>
                <p class="text-xs font-medium text-slate-500">Tenant #{{auth()->user()->tenant_id}}</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                     <tr>
                         <th class="px-6 py-3">Name</th>
                         <th class="px-6 py-3">Role</th>
                         <th class="px-6 py-3">Clinic Details</th>
                         <th class="px-6 py-3"> Email</th>
                     </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                     @foreach($staffMembers as $member)
                         <tr>
                             <td class="px-6 py-4 font-semibold text-slate-900">{{$member->name}}</td>
                             <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 uppercase">Clinic Overview
                                    {{str_replace('_','',$member->role)}}
                               </span>
                             </td>
                             <td class="px-6 py-4 text-xs text-slate-600">
                               @if($member->doctorProfile)
                                  {{$member->doctorProfile->specialization}}({{$member->doctorProfile->license_number}})
                               @else
                                   Administrative/FrontDesk
                               @endif
                             </td>
                             <td class="px-6 py-4 text-xs text-slate-600">{{$member->email}}</td>
                         </tr>
                     @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
