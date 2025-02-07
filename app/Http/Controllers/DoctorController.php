<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Validator;
use Toastr;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::orderBy('created_at', 'desc')->get();
        return view('doctor.index', compact('doctors'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("doctor.create");
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
                'email' => 'required|email|unique:doctors,email',
                'phone' => 'required|string|max:20|unique:doctors,phone',
                'specialization' => 'required|string|max:255',
                'license_number' => 'required|string|max:255|unique:doctors,license_number',
                'address' => 'nullable|string|max:500',
                'gender' => 'required|in:Male,Female,Other',
                'dob' => 'nullable|date',
                'consultation_fee' => 'required|numeric|min:0',
                'experience' => 'required|string',
                'availability_status' => 'required|in:active,inactive',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Failed');
            }
            return back()->withInput();
        }

        $doctor = new Doctor();
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->email = $request->email;
        $doctor->phone = $request->phone;
        $doctor->specialization = $request->specialization;
        $doctor->license_number = $request->license_number;
        $doctor->address = $request->address;
        $doctor->gender = $request->gender;
        $doctor->dob = $request->dob;
        $doctor->consultation_fee = $request->consultation_fee;
        $doctor->experience = $request->experience;
        $doctor->availability_status = $request->availability_status;
        $doctor->created_by = auth()->id();

        if ($doctor->save()) {
            Toastr::success('Success', 'Doctor created successfully!');
            return redirect()->route('doctors.index');
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
        $doctor = Doctor::findOrFail($id);
        return view('doctor.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctor.edit', compact('doctor'));
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
                'specialization' => 'required|string|max:255',
                'license_number' => 'required|string|max:255',
                'address' => 'nullable|string|max:500',
                'gender' => 'required|in:Male,Female,Other',
                'dob' => 'nullable|date',
                'consultation_fee' => 'required|numeric|min:0',
                'experience' => 'required|string',
                'availability_status' => 'required|in:active,inactive',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Failed');
            }
            return back()->withInput();
        }

        $doctor = Doctor::findOrFail($id);
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->email = $request->email;
        $doctor->phone = $request->phone;
        $doctor->specialization = $request->specialization;
        $doctor->license_number = $request->license_number;
        $doctor->address = $request->address;
        $doctor->gender = $request->gender;
        $doctor->dob = $request->dob;
        $doctor->consultation_fee = $request->consultation_fee;
        $doctor->experience = $request->experience;
        $doctor->availability_status = $request->availability_status;
        $doctor->updated_by = auth()->id();

        if ($doctor->save()) {
            Toastr::success('Success', 'Doctor updated successfully!');
            return redirect()->route('doctors.index');
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
        $doctor = Doctor::findOrFail($id);
        $delete = $doctor->delete();

        // Check if deletion was successful
        if ($delete) {
            Toastr::success('Success', 'Doctor deleted successfully!');
            return redirect()->route('doctors.index');
        } else {
            Toastr::error('Error', 'An issue occurred while deleting the doctor.');
            return redirect()->back();
        }
    }
}
