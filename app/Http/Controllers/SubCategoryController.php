<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Validator;
use Toastr;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')->get();
        return view('sub_category.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('sub_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validator = Validator::make(
            $request->all(),[
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }

        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->is_active = $request->is_active ?? true;
        $subCategory->created_by = auth()->id();
        $save = $subCategory->save();
        if ($save) {
            Toastr::success('Success', 'Sub Category added successfully!');
            return redirect()->route('sub-categories.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $categories = Category::where('is_active', 1)->get();
        return view('sub_category.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),[
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'is_active' => 'boolean',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }

        $subCategory = SubCategory::findOrFail($id);
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->is_active = $request->is_active ?? true;
        $subCategory->updated_by = auth()->id();
        $save = $subCategory->save();
        if ($save) {
            Toastr::success('Success', 'Sub Category updated successfully!');
            return redirect()->route('sub-categories.index');
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
        $subCategory = SubCategory::findOrFail($id);
        $delete = $subCategory->delete();
        if ($delete) {
            Toastr::success('Success', 'Sub Category deleted successfully!');
            return redirect()->route('sub-categories.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }

    }
}