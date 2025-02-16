<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Manufacturer;
use App\Models\Unit;
use Validator;
use Toastr;
use File;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicines = Medicine::orderBy('id', 'DESC')->get();
        return view('medicine.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        $subcategorys = SubCategory::where('is_active', 1)->get();
        $manufacturers = Manufacturer::where('is_active', 1)->get();
        $units = Unit::where('is_active', 1)->get();

        return view('medicine.create', compact(['categories', 'subcategorys', 'manufacturers', 'units']));
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
                'subcategory_id' => 'required',
                'category_id' => 'required',
                'manufacturer_id' => 'required',
                'unit_id' => 'required',
                'purchase_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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

        $medicine = new Medicine();
        $medicine->name = $request->name;
        $medicine->subcategory_id = $request->subcategory_id;
        $medicine->category_id = $request->category_id;
        $medicine->manufacturer_id = $request->manufacturer_id;
        $medicine->unit_id = $request->unit_id;
        $medicine->purchase_price = $request->purchase_price;
        $medicine->sale_price = $request->sale_price;
        // Handle image upload if available
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/medicines/', $filename);
            $medicine->image = $filename;
        }
        $medicine->is_active = $request->is_active ?? true;
        $medicine->created_by = auth()->id();
        $save = $medicine->save();
        if ($save) {
            Toastr::success('Success', 'Medicine added successfully!');
            return redirect()->route('medicines.index');
        } else {
            Toastr::error('Error', 'An error occurred while saving the medicine.');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medicine = Medicine::with(['category', 'subcat', 'manufacturer', 'unit'])->findOrFail($id);

        return view('medicine.show', compact('medicine'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        $categories = Category::where('is_active', 1)->get();
        $subcategorys = SubCategory::where('is_active', 1)->get();
        $manufacturers = Manufacturer::where('is_active', 1)->get();
        $units = Unit::where('is_active', 1)->get();

        return view('medicine.edit', compact(['medicine', 'categories', 'subcategorys', 'manufacturers', 'units']));
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
                'subcategory_id' => 'required',
                'category_id' => 'required',
                'manufacturer_id' => 'required',
                'unit_id' => 'required',
                'purchase_price' => 'required|numeric|min:0',
                'sale_price' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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

        $medicine = Medicine::findOrFail($id);
        $medicine->name = $request->name;
        $medicine->subcategory_id = $request->subcategory_id;
        $medicine->category_id = $request->category_id;
        $medicine->manufacturer_id = $request->manufacturer_id;
        $medicine->unit_id = $request->unit_id;
        $medicine->purchase_price = $request->purchase_price;
        $medicine->sale_price = $request->sale_price;
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            $destination = 'uploads/medicines/' . $medicine->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            // Store the new image
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/medicines/', $filename);
            $medicine->image = $filename;
        }
        $medicine->is_active = $request->is_active ?? true;
        $medicine->updated_by = auth()->id();
        $save = $medicine->save();
        if ($save) {
            Toastr::success('Success', 'medicine updated successfully!');
            return redirect()->route('medicines.index');
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
        $medicine = Medicine::findOrFail($id);

        // Delete the medicine image if it exists
        $imagePath = 'uploads/medicines/' . $medicine->image;
        if ($medicine->image && File::exists($imagePath)) {
            File::delete($imagePath); // Delete the image file
        }

        $delete = $medicine->delete();
        if ($delete) {
            Toastr::success('Success', 'Medicine deleted successfully!');
            return redirect()->route('medicines.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }
    }
    public function getMedicineDetails($id)
    {
        $medicine = Medicine::find($id);

        if ($medicine) {
            return response()->json([
                'unit_name' => optional($medicine->unit)->name, // Avoid error if unit is null
                'purchase_price' => $medicine->purchase_price,
                'sale_price' => $medicine->sale_price,
                'stock' => $medicine->stock,
            ]);
        } else {
            return response()->json(['error' => 'Medicine not found'], 404);
        }
    }
}
