<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class StaffController extends Controller
{
    public function store(Request $request):RedirectResponse{
        $validated=$request->validate([
            'name'=>['required','string','max:255'],
            'email'=>['required','string','email','max:255','unique:users,email'],
            'password'=>['required','string','min:8'],
            'role'=>['required',Rule::in([User::ROLE_DOCTOR,User::ROLE_RECEPTIONIST])],
            'specialization'=>['required_if:role,doctor','nullable','string','max:255'],
            'license_number'=>['required_if:role,doctor','nullable','string','max:100','unique:doctors,license_number'],
            'phone'=>['required_if:role,doctor','nullable','string','max:30'],
        ]);
        DB::transaction(function() use ($validated){
            $user=User::create([
                'name'=>$validated['name'],
                'email'=>$validated['email'],
                'password'=>Hash::make($validated['password']),
                'tenant_id'=>auth()->user()->id,
                'role'=>$validated['role'],

            ]);
            if($validated['role']===User::ROLE_DOCTOR) {
                DOCTOR::create([
                    'tenant_id' => auth()->user()->id,
                    'user_id' => $user->id,
                    'specialization' => $validated['specialization'],
                    'license_number' => $validated['license_number'],
                    'phone' => $validated['phone'],
                    'status' => 'active',

                ]);
            }
        });
        return redirect()->route('admin.dashboard')->with('status','Staff member onboard successfully');

    }
}
