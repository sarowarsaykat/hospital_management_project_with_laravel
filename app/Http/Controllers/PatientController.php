<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Validator;
use Toastr;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::orderBy('created_at', 'desc')->get();
        return view('patient.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("patient.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:patients,email',
                'phone' => 'required|string|max:20|unique:patients,phone',
                'gender' => 'required|in:Male,Female,Other',
                'dob' => 'required|date',
                'address' => 'required|string|max:500',
                'blood_type' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
                'emergency_contact' => 'required|string|max:20',
                'medical_history' => 'nullable|string',
                'is_active' => 'required|in:active,inactive',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Failed');
            }
            return back()->withInput();
        }

        $patient = new Patient();
        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->email = $request->email;
        $patient->phone = $request->phone;
        $patient->gender = $request->gender;
        $patient->dob = $request->dob;
        $patient->address = $request->address;
        $patient->blood_type = $request->blood_type;
        $patient->emergency_contact = $request->emergency_contact;
        $patient->medical_history = $request->medical_history;
        $patient->is_active = $request->is_active;
        $patient->created_by = auth()->id();

        if ($patient->save()) {
            Toastr::success('Success', 'Patient created successfully!');
            return redirect()->route('patients.index');
        } else {
            Toastr::error('Error', 'Something went wrong');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'gender' => 'required|in:Male,Female,Other',
                'dob' => 'required|date',
                'address' => 'required|string|max:500',
                'blood_type' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
                'emergency_contact' => 'required|string|max:20',
                'medical_history' => 'nullable|string',
                'is_active' => 'required|in:active,inactive',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Failed');
            }
            return back()->withInput();
        }

        $patient = Patient::findOrFail($id);
        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->email = $request->email;
        $patient->phone = $request->phone;
        $patient->gender = $request->gender;
        $patient->dob = $request->dob;
        $patient->address = $request->address;
        $patient->blood_type = $request->blood_type;
        $patient->emergency_contact = $request->emergency_contact;
        $patient->medical_history = $request->medical_history;
        $patient->is_active = $request->is_active;
        $patient->updated_by = auth()->id();

        if ($patient->save()) {
            Toastr::success('Success', 'Patient updated successfully!');
            return redirect()->route('patients.index');
        } else {
            Toastr::error('Error', 'Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $delete = $patient->delete();

        if ($delete) {
            Toastr::success('Success', 'Patient deleted successfully!');
            return redirect()->route('patients.index');
        } else {
            Toastr::error('Error', 'An issue occurred while deleting the patient.');
            return redirect()->back();
        }
    }
}
