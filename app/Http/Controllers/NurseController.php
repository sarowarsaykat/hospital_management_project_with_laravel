<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use Illuminate\Http\Request;
use Validator;
use Toastr;

class NurseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nurses = Nurse::orderBy('created_at', 'desc')->get();
        return view('nurse.index', compact('nurses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("nurse.create");
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
                'email' => 'required|email|unique:nurses,email',
                'phone' => 'required|string|max:20|unique:nurses,phone',
                'gender' => 'required|in:Male,Female,Other',
                'dob' => 'nullable|date',
                'qualification' => 'required|string|max:255',
                'nursing_license_number' => 'required|string|max:255|unique:nurses,nursing_license_number',
                'department' => 'required|string|max:255',
                'address' => 'nullable|string|max:500',
                'salary' => 'required|numeric|min:0',
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

        $nurse = new Nurse();
        $nurse->first_name = $request->first_name;
        $nurse->last_name = $request->last_name;
        $nurse->email = $request->email;
        $nurse->phone = $request->phone;
        $nurse->gender = $request->gender;
        $nurse->dob = $request->dob;
        $nurse->qualification = $request->qualification;
        $nurse->nursing_license_number = $request->nursing_license_number;
        $nurse->department = $request->department;
        $nurse->address = $request->address;
        $nurse->salary = $request->salary;
        $nurse->experience = $request->experience;
        $nurse->availability_status = $request->availability_status;
        $nurse->created_by = auth()->id();

        if ($nurse->save()) {
            Toastr::success('Success', 'Nurse created successfully!');
            return redirect()->route('nurses.index');
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
        $nurse = Nurse::findOrFail($id);
        return view('nurse.show', compact('nurse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nurse = Nurse::findOrFail($id);
        return view('nurse.edit', compact('nurse'));
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
                'dob' => 'nullable|date',
                'qualification' => 'required|string|max:255',
                'nursing_license_number' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'address' => 'nullable|string|max:500',
                'salary' => 'required|numeric|min:0',
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

        $nurse = Nurse::findOrFail($id);
        $nurse->first_name = $request->first_name;
        $nurse->last_name = $request->last_name;
        $nurse->email = $request->email;
        $nurse->phone = $request->phone;
        $nurse->gender = $request->gender;
        $nurse->dob = $request->dob;
        $nurse->qualification = $request->qualification;
        $nurse->nursing_license_number = $request->nursing_license_number;
        $nurse->department = $request->department;
        $nurse->address = $request->address;
        $nurse->salary = $request->salary;
        $nurse->experience = $request->experience;
        $nurse->availability_status = $request->availability_status;
        $nurse->updated_by = auth()->id();

        if ($nurse->save()) {
            Toastr::success('Success', 'Nurse updated successfully!');
            return redirect()->route('nurses.index');
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
        $nurse = Nurse::findOrFail($id);
        $delete = $nurse->delete();

        if ($delete) {
            Toastr::success('Success', 'Nurse deleted successfully!');
            return redirect()->route('nurses.index');
        } else {
            Toastr::error('Error', 'An issue occurred while deleting the nurse.');
            return redirect()->back();
        }
    }
}
