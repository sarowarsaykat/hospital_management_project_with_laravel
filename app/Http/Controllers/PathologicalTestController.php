<?php

namespace App\Http\Controllers;

use App\Models\PathologicalTest;
use Illuminate\Http\Request;
use Validator;
use Toastr;

class PathologicalTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pathologicalTests = PathologicalTest::orderBy('created_at', 'desc')->get();
        return view('pathological_test.index', compact('pathologicalTests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pathological_test.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'test_name' => 'required|string|max:255',
                'test_code' => 'required|string|max:255|unique:pathological_tests,test_code',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'status' => 'required|in:active,inactive',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Failed');
            }
            return back()->withInput();
        }

        $test = new PathologicalTest();
        $test->test_name = $request->test_name;
        $test->test_code = $request->test_code;
        $test->description = $request->description;
        $test->price = $request->price;
        $test->status = $request->status;
        $test->created_by = auth()->id();

        if ($test->save()) {
            Toastr::success('Success', 'Pathological Test created successfully!');
            return redirect()->route('pathological-tests.index');
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
        $test = PathologicalTest::findOrFail($id);
        return view('pathological_test.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pathologicalTest = PathologicalTest::findOrFail($id);
        return view('pathological_test.edit', compact('pathologicalTest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'test_name' => 'required|string|max:255',
                'test_code' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'status' => 'required|in:active,inactive',
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Failed');
            }
            return back()->withInput();
        }

        $test = PathologicalTest::findOrFail($id);
        $test->test_name = $request->test_name;
        $test->test_code = $request->test_code;
        $test->description = $request->description;
        $test->price = $request->price;
        $test->status = $request->status;
        $test->updated_by = auth()->id();

        if ($test->save()) {
            Toastr::success('Success', 'Pathological Test updated successfully!');
            return redirect()->route('pathological-tests.index');
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
        $test = PathologicalTest::findOrFail($id);
        $delete = $test->delete();

        if ($delete) {
            Toastr::success('Success', 'Pathological Test deleted successfully!');
            return redirect()->route('pathological-tests.index');
        } else {
            Toastr::error('Error', 'An issue occurred while deleting the test.');
            return redirect()->back();
        }
    }
}
