<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Validator;
use Toastr;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();
        return view('unit.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
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


        $unit = new Unit();
        $unit->name = $request->name;
        $unit->is_active = $request->is_active ?? true;
        $unit->created_by = auth()->id();
        $save = $unit->save();
        if ($save) {
            Toastr::success('Success', 'Unit added successfully!');
            return redirect()->route('units.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
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

        $unit = Unit::findOrFail($id);
        $unit->name = $request->name;
        $unit->is_active = $request->is_active ?? true;
        $unit->updated_by = auth()->id();
        $save = $unit->save();
        if ($save) {
            Toastr::success('Success', 'Unit updated successfully!');
            return redirect()->route('units.index');
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
        $unit = Unit::findOrFail($id);
        $delete = $unit->delete();
        if ($delete) {
            Toastr::success('Success', 'Unit deleted successfully!');
            return redirect()->route('units.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }
    }
}