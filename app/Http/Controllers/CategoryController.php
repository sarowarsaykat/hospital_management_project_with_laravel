<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use Toastr;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view("category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),[
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }
       

        $category = new Category();
        $category->name = $request->name;
        $category->is_active = $request->is_active ?? true;
        $category->created_by = auth()->id();
        $save = $category->save();
        if ($save) {
            Toastr::success('Success', 'Category added successfully!');
            return redirect()->route('category.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),[
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }

        $category = Category::findOrFail($id); // Find the category by ID or fail
        $category->name = $request->name;
        $category->is_active = $request->is_active ?? true;
        $category->updated_by = auth()->id();
        $save = $category->save();
        if ($save) {
            Toastr::success('Success', 'Category updated successfully!');
            return redirect()->route('category.index');
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
        $category = Category::findOrFail($id);
        $delete = $category->delete();
        if ($delete) {
            Toastr::success('Success', 'Category deleted successfully!');
            return redirect()->route('category.index');
        } else {
            Toastr::error('Error', 'Any Problem Occured');
            return redirect()->back();
        }
    }
}
