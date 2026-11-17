<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Patient;


class PatientController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=Patient::query();
        if($request->filled('search')){
            $search=$request->search;
            $query->where(function($q) use ($search){
                $q->where('name','like',"%$search%")
                    ->orWhere('phone','like',"%$search%")
                    ->orWhere('patient_number','like',"%$search%")
                    ->orWhere('email','like',"%$search%");
            });
        }
        $patients=$query->latest()->paginate(15)->withQueryString();
        return view('patients.index',compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //print_r($request);
        $validated=$request->validate([
            'name'=>'required|string|max:255',
            'date_of_birth'=>'required|date|before:today',
            'gender'=>'required|in:male,female,both',
            'phone'=>'required|string|max:20',
            'email'=>'nullable|email|max:255',
            'medical_history'=>'nullable|string',
        ]);
        Patient::create($validated);
        return redirect()->route('patients.index')->with('success','Patient register successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load(['appointments'=>function($query){
            $query->latest('appointment_date');

        }]);
        return view('patients.show',compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit',compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated=$request->validate([
            'name'=>'required|string|max:255',
            'date_of_birth'=>'required|date|before:today',
            'gender'=>'required|in:male,female,both',
            'phone'=>'required|string|max:20',
            'email'=>'nullable|email|max:255',
            'medical_history'=>'nullable|string',
        ]);
        $patient->update($validated);
        return redirect()->route('patients.index')->with('success','Patient record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success','Patient record remove successfully');

    }
}
