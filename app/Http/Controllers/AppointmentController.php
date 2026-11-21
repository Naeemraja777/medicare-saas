<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=Appointment::with(['patient','doctor.user'])->orderBy('appointments.appointment_date','asc');
        //Restrict doctor to only their own appointments
        if(Auth::user()->role===User::ROLE_DOCTOR &&Auth::user()->doctorProfile){
            $query->where('doctor_id',Auth::user()->doctorProfile()->id);
        }
        if($request->filled('status')){
            $query->where('status',$request->status);
        }
        if($request->filled('date')){
            $query->whereDate('appointment_date',$request->date);
        }
        $appointments=$query->paginate(12)->withQueryString();
        return view('appointments.index',compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //only admin and reception can book new appointments
        abort_if(Auth::user()->role===User::ROLE_DOCTOR,403);
        $patients=Patient::orderBy('name')->get();
        $doctors=Doctor::with('user')->where('status','active')->get();
        $selectedPatientId=$request->query('patient_id');
        return view('appointments.create',compact('patients','doctors','selectedPatientId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Auth::user()->role === User::ROLE_DOCTOR, 403);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:now',
            'symptoms_descriptions' => 'nullable|string|max:2000',
        ]);
        $appointmentTime=Carbon::parse($validated['appointment_date']);
        $duplicate_patient = Appointment::where('patient_id', $validated['patient_id'])
            ->where('doctor_id', $validated['doctor_id'])
            ->whereDate('appointment_date',$appointmentTime->toDateString())
            ->where('status', Appointment::STATUS_SCHEDULED)->exists();
        if($duplicate_patient){
            return back()->withInput()->withErrors(['patient_id'=>'This patient has already scheduled appointment with this doctor']);
        }
        $doctorConflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('status',Appointment::STATUS_SCHEDULED)
            ->whereBetween('appointment_date',[
                $appointmentTime->copy()->subMinutes(14),
                $appointmentTime->copy()->addMinutes(14),

            ])->exists();
        if($doctorConflict){
            return back()->withInput()->withErrors(['appointment_date'=>'This doctor already has a scheduled appointment with in 15 minutes of the time']);
        }
          $validated['appointment_date']=$appointmentTime;
        //prevent double booking at the same doctor at same timestamp

        Appointment::create($validated);
        return redirect()->route('appointments.index')->with('success','Appointment scheduled successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $this->authorizeDoctorAccess($appointment);
        $appointment->load(['patient','doctor.user']);
        return view('appointments.show',compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients=Patient::orderBy('name')->get();
        $doctors=Doctor::with('user')->get();
        return view('appointments.edit',compact('appointment','patients','doctors'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:scheduled,completed,cancelled,no_show',
            'symptoms_descriptions' => 'nullable|string|max:2000',
            'doctor_notes' => 'nullable|string|max:5000',
        ]);
        $appointment->update($validated);
        return redirect()->route('appointments.show',$appointment)->with('success','Appointment updated successfully');

        //
    }
    public function updateStatus(Request $request,Appointment $appointment){
        $this->authorizeDoctorAccess($appointment);
        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled,no_show',
        ]);
        $appointment->update(['status'=>$validated['status']]);
        return back()->with('success','Appointment Status updated');

    }
    public function authorizeDoctorAccess(Appointment $appointment){
        if(Auth::user()->role===User::ROLE_DOCTOR && Auth::user()->doctorProfile?->id!==$appointment->doctor_id){
            abort(403,'Unauthorized access to another doctor appointment');

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        abort_unless(Auth::user()->role===User::ROLE_ADMIN,403);
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success','Appointment deleted');


    }

}
