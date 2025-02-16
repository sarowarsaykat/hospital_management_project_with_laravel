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
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'medicine_id.*' => 'required|exists:medicines,id',  // Changed to medicine_id
            'sale_price.*' => 'required|numeric|min:0',
            'purchase_price.*' => 'required|numeric|min:0',  // Added validation for purchase_price
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

        // Creating the Sales Master entry
        $salesMaster = new SalesMaster();
        $salesMaster->customer_id = $request->customer_id;
        $salesMaster->sale_date = $request->sale_date;
        $salesMaster->total_quantity = array_sum($request->quantity);
        $salesMaster->total_amount = array_sum(array_map(function ($quantity, $price) {
            return $quantity * $price;
        }, $request->quantity, $request->sale_price));
        $salesMaster->payment_method = $request->payment_method;
        $salesMaster->payment = $request->payment;
        $salesMaster->created_by = auth()->id();
        $salesMaster->save();

        // Loop through each medicine and create a sales detail entry
        foreach ($request->medicine_id as $index => $medicineId) {
            // Create Sales Detail entry
            $saleDetail = new SalesDetail();
            $saleDetail->sales_master_id = $salesMaster->id;
            $saleDetail->medicine_id = $medicineId;  // Changed to medicine_id
            $saleDetail->sale_price = $request->sale_price[$index];
            $saleDetail->purchase_price = $request->purchase_price[$index];  // Added purchase_price
            $saleDetail->quantity = $request->quantity[$index];
            $saleDetail->total = $saleDetail->sale_price * $saleDetail->quantity; // Total for this sale item
            $saleDetail->unit = $request->unit[$index];
            $saleDetail->stock = $request->stock[$index];
            $saleDetail->save();

            // **Adjust Medicine Stock**
            $medicine = Medicine::find($medicineId);  // Find the medicine
            if ($medicine) {
                $medicine->stock -= $request->quantity[$index];  // Reduce stock by the sale quantity
                $medicine->save();  // Save the updated stock in the database
            }
        }

        // Display success message and redirect to the sales index page
        Toastr::success('Sale created successfully!');
        return redirect()->route('sales.index');
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = SalesMaster::with(['salesDetails.medicine', 'salesDetails.unit', 'customer'])->findOrFail($id);
        return view('medicine_sale.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = [
            'salesMaster'  => SalesMaster::with('salesDetails')->findOrFail($id),
            'salesDetails' => SalesDetail::where('sales_master_id', $id)->get(),
            'customers' => Customer::where('is_active', 1)->get(),
            'medicines' => Medicine::where('is_active', 1)->get(),
        ];

        return view('medicine_sale.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate Request
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'medicine_id.*' => 'required|exists:medicines,id',
            'unit.*' => 'required|string',
            'purchase_price.*' => 'required|numeric|min:0',
            'sale_price.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|numeric|min:1',
            'stock.*' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Validation Error');
            }
            return back()->withInput();
        }

        // Find the sales record
        $salesMaster = SalesMaster::findOrFail($id);

        // Restore stock before updating
        foreach ($salesMaster->salesDetails as $detail) {
            $medicine = Medicine::find($detail->medicine_id);
            if ($medicine) {
                $medicine->stock += $detail->quantity; // Restore previous stock
                $medicine->save();
            }
        }

        // Delete existing sales details
        $salesMaster->salesDetails()->delete();

        // Update Sales Master Data
        $salesMaster->customer_id = $request->customer_id;
        $salesMaster->sale_date = $request->sale_date;
        $salesMaster->total_quantity = array_sum($request->quantity);
        $salesMaster->total_amount = array_sum(array_map(function ($quantity, $price) {
            return $quantity * $price;
        }, $request->quantity, $request->sale_price));
        $salesMaster->payment_method = $request->payment_method;
        $salesMaster->payment = $request->payment;
        $salesMaster->updated_by = auth()->id();
        $salesMaster->save();

        // Insert New Sales Details
        foreach ($request->medicine_id as $index => $medicineId) {
            $details = new SalesDetail();
            $details->sales_master_id = $salesMaster->id;
            $details->medicine_id = $medicineId;
            $details->unit = $request->unit[$index];
            $details->purchase_price = $request->purchase_price[$index];
            $details->sale_price = $request->sale_price[$index];
            $details->quantity = $request->quantity[$index];
            $details->stock = $request->stock[$index];
            $details->total = $details->sale_price * $details->quantity;
            $details->save();

            // Update Medicine Stock
            $medicine = Medicine::find($medicineId);
            if ($medicine) {
                $medicine->stock -= $request->quantity[$index]; // Deduct new stock
                $medicine->save();
            }
        }

        Toastr::success('Sale updated successfully!');
        return redirect()->route('sales.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $salesMaster = SalesMaster::find($id);

        // Check if the SalesMaster exists
        if (!$salesMaster) {
            Toastr::error('Sale not found', 'Error');
            return redirect()->route('sales.index');
        }

        // Loop through each SalesDetail to restore stock to the medicines
        foreach ($salesMaster->salesDetails as $saleDetail) {
            $medicine = Medicine::find($saleDetail->medicine_id);
            if ($medicine) {
                $medicine->stock += $saleDetail->quantity; // Restore the stock
                $medicine->save(); // Save the updated stock
            }

            // Delete the SalesDetail record
            $saleDetail->delete();
        }

        // Finally, delete the SalesMaster record
        $salesMaster->delete();

        Toastr::success('Sale deleted successfully!');
        return redirect()->route('sales.index');
    }
}
