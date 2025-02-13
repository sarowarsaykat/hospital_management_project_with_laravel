<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Medicine;
use App\Models\SalesDetail;
use App\Models\SalesMaster;
use Illuminate\Http\Request;
use Validator;
use Toastr;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = SalesMaster::with('customer')->orderBy('sale_date', 'desc')->get();
        return view('medicine_sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('is_active', 1)->get();
        $medicines = Medicine::where('is_active', 1)->get();
        return view('medicine_sale.create', compact(['customers', 'medicines']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'medicine_id.*' => 'required|exists:medicines,id',
            'quantity.*' => 'required|numeric|min:1',
            'sale_price.*' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }

        $salesMaster = new SalesMaster();
        $salesMaster->customer_id = $request->customer_id;
        $salesMaster->sale_date = $request->sale_date;
        $salesMaster->total_quantity = array_sum($request->quantity);
        $salesMaster->total_amount = array_sum(array_map(fn($quantity, $price) => $quantity * $price, $request->quantity, $request->sale_price));
        $salesMaster->payment_method = $request->payment_method;
        $salesMaster->payment = $request->payment;
        $salesMaster->created_by = auth()->id();
        $salesMaster->save();

        foreach ($request->medicine_id as $index => $medicineId) {
            $medicine = Medicine::find($medicineId);

            $details = new SalesDetail();
            $details->sales_master_id = $salesMaster->id;
            $details->medicine_id = $medicineId;
            $details->sale_price = $request->sale_price[$index];
            $details->quantity = $request->quantity[$index];
            $details->total = $details->sale_price * $details->quantity;
            $details->purchase_price = $medicine->purchase_price ?? 0;

            $details->save();

            if ($medicine) {
                $medicine->stock -= $request->quantity[$index];
                $medicine->save();
            }
        }

        Toastr::success('Sale created successfully!');
        return redirect()->route('sales.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
