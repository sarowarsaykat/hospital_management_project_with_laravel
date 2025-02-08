<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Validator;
use Toastr;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manufacturers = Manufacturer::all();
        return view('manufacturer.index', compact('manufacturers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manufacturer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'company_name' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'is_active' => 'boolean',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }

        $manufacturer = new Manufacturer();
        $manufacturer->company_name = $request->company_name;
        $manufacturer->country = $request->country;
        $manufacturer->is_active = $request->is_active ?? true;
        $manufacturer->created_by = auth()->id();
        $save = $manufacturer->save();
        if ($save) {
            Toastr::success('Success', 'Manufacturer added successfully!');
            return redirect()->route('manufacturer.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        return view('manufacturer.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'company_name' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'is_active' => 'boolean',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }


        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->company_name = $request->company_name;
        $manufacturer->country = $request->country;
        $manufacturer->is_active = $request->is_active ?? true;
        $manufacturer->updated_by = auth()->id();
        $save = $manufacturer->save();
        if ($save) {
            Toastr::success('Success', 'Manufacturer updated successfully!');
            return redirect()->route('manufacturer.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $delete = $manufacturer->delete();
        
        if ($delete) {
            Toastr::success('Success', 'Manufacturer deleted successfully!');
            return redirect()->route('manufacturer.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }

    }
}