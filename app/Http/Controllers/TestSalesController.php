<?php

namespace App\Http\Controllers;


use App\Models\Patient;
use App\Models\PathologicalTest;
use App\Models\TestSalesDetail;
use App\Models\TestSalesMaster;
use Illuminate\Http\Request;
use Validator;
use Toastr;


class TestSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all test sales, including related patient data
        $testSales = TestSalesMaster::with('patient')->get();
        return view('test_sale.index', compact('testSales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::where('is_active', 'active')->get();
        $tests = PathologicalTest::all();

        return view('test_sale.create', compact('patients', 'tests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'sale_date' => 'required|date',
            'test_id.*' => 'required',
            'price.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|numeric|min:1',
            'total.*' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment' => 'required|numeric|min:0',
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Error');
            }
            return back()->withInput();
        }

        // Creating the Test Sale Master entry
        $testSaleMaster = new TestSalesMaster();
        $testSaleMaster->patient_id = $request->patient_id;
        $testSaleMaster->sale_date = $request->sale_date;
        $testSaleMaster->total_quantity = array_sum($request->quantity);
        $testSaleMaster->total_amount = array_sum(array_map(function ($quantity, $total) {
            return $quantity * $total;
        }, $request->quantity, $request->total));
        $testSaleMaster->payment_method = $request->payment_method;
        $testSaleMaster->payment = $request->payment;
        $testSaleMaster->created_by = auth()->id();
        $saveMaster = $testSaleMaster->save();

        if ($saveMaster) {
            foreach ($request->test_id as $index => $testId) {
                $testSaleDetail = new TestSalesDetail();
                $testSaleDetail->test_sale_master_id = $testSaleMaster->id;
                $testSaleDetail->test_id = $testId;
                $testSaleDetail->price = $request->price[$index];
                $testSaleDetail->quantity = $request->quantity[$index];
                $testSaleDetail->total = $request->total[$index];
                $testSaleDetail->save();
            }

            Toastr::success('Success', 'Test Sale created successfully!');
            return redirect()->route('test-sales.index');
        } else {
            Toastr::error('Error', 'An error occurred while creating the Test Sale.');
            return redirect()->back();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $testSaleMaster = TestSalesMaster::with('patient', 'testSalesDetails.pathologicalTest')->findOrFail($id);

        return view('test_sale.show', compact('testSaleMaster'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = [
            'testSalesMaster'  => TestSalesMaster::with('testSalesDetails')->findOrFail($id),
            'testSalesDetails' => TestSalesDetail::where('test_sale_master_id', $id)->get(),
            'patients' => Patient::where('is_active', 'active')->get(),
            'tests' => PathologicalTest::where('status', 'active')->get(),
        ];

        return view('test_sale.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'sale_date' => 'required|date',
            'test_id.*' => 'required',
            'price.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|numeric|min:1',
            'total.*' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,bkash,nagad,rocket',
            'payment' => 'required|numeric|min:0',
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Error');
            }
            return back()->withInput();
        }

        // Fetch the existing Test Sale Master entry
        $testSaleMaster = TestSalesMaster::findOrFail($id);
        $testSaleMaster->patient_id = $request->patient_id;
        $testSaleMaster->sale_date = $request->sale_date;
        $testSaleMaster->total_quantity = array_sum($request->quantity);
        $testSaleMaster->total_amount = array_sum(array_map(function ($quantity, $total) {
            return $quantity * $total;
        }, $request->quantity, $request->total));
        $testSaleMaster->payment_method = $request->payment_method;
        $testSaleMaster->payment = $request->payment;
        $testSaleMaster->updated_by = auth()->id();
        $saveMaster = $testSaleMaster->save();

        if ($saveMaster) {
            // Remove old details
            TestSalesDetail::where('test_sale_master_id', $id)->delete();

            // Insert updated details
            foreach ($request->test_id as $index => $testId) {
                $testSaleDetail = new TestSalesDetail();
                $testSaleDetail->test_sale_master_id = $testSaleMaster->id;
                $testSaleDetail->test_id = $testId;
                $testSaleDetail->price = $request->price[$index];
                $testSaleDetail->quantity = $request->quantity[$index];
                $testSaleDetail->total = $request->total[$index];
                $testSaleDetail->save();
            }

            Toastr::success('Success', 'Test Sale updated successfully!');
            return redirect()->route('test-sales.index');
        } else {
            Toastr::error('Error', 'An error occurred while updating the Test Sale.');
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $testSale = TestSalesMaster::findOrFail($id);
        $testSale->testSalesDetails()->delete();
        $delete = $testSale->delete();

        if ($delete) {
            Toastr::success('Success', 'Test sale and related details deleted successfully!');
            return redirect()->route('test-sales.index');
        } else {
            Toastr::error('Error', 'An error occurred while deleting the test sale.');
            return redirect()->back();
        }
    }
}
