<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\PurchaseDetails;
use App\Models\PurchaseMaster;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Unit;
use Validator;
use Toastr;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = PurchaseMaster::with('supplier')->orderBy('id', 'desc')->get();
        return view('purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $medicines = Medicine::all();


        return view('purchase.create', compact('suppliers', 'medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'medicine_id.*' => 'required|exists:medicines,id',
            'unit_id.*' => 'required|exists:units,id',
            'purchase_price.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }

        $purchaseMaster = new PurchaseMaster();
        $purchaseMaster->supplier_id = $request->supplier_id;
        $purchaseMaster->purchase_date = $request->purchase_date;
        $purchaseMaster->total_quantity = array_sum($request->quantity);
        $purchaseMaster->total_amount = array_sum(array_map(function ($quantity, $price) {
            return $quantity * $price;
        }, $request->quantity, $request->purchase_price));
        $purchaseMaster->created_by = auth()->id();
        $purchaseMaster->save();
        // dd( $request);
        // exit;

        foreach ($request->medicine_id as $index => $medicineId) {
            $details = new PurchaseDetails();
            $details->purchase_master_id = $purchaseMaster->id;
            $details->medicine_id = $medicineId;
            $details->unit_id = $request->unit_id[$index];
            $details->purchase_price = $request->purchase_price[$index];
            $details->quantity = $request->quantity[$index];
            $details->total = $details->purchase_price * $details->quantity;
            $details->save();

            // **Medicine Stock Update**
            $medicine = Medicine::find($medicineId);
            if ($medicine) {
                $medicine->stock += $request->quantity[$index];
                $medicine->save();
            }
        }

        Toastr::success('Success', 'Purchase created successfully!');
        return redirect()->route('purchases.index');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Retrieve the purchase details with related data
        $purchase = PurchaseMaster::with(['details.medicine', 'details.unit', 'supplier'])
            ->findOrFail($id);
        return view('purchase.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the purchase record along with related details
        $purchase = PurchaseMaster::with('details.medicine', 'details.unit', 'supplier')->findOrFail($id);
        $suppliers = Supplier::all();
        $medicines = Medicine::all();
        $units = Unit::all();
        return view('purchase.edit', compact('purchase', 'suppliers', 'medicines', 'units'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'medicine_id.*' => 'required|exists:medicines,id',
            'unit_id.*' => 'required|exists:units,id',
            'purchase_price.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Toastr::error($message, 'Failed');
            }
            return back()->withInput();
        }

        // Find the purchase record
        $purchaseMaster = PurchaseMaster::findOrFail($id);

        //Restore Stock Before Updating
        foreach ($purchaseMaster->details as $detail) {
            $medicine = Medicine::find($detail->medicine_id);
            if ($medicine) {
                $medicine->stock -= $detail->quantity; // Reverting stock
                $medicine->save();
            }
        }

        //Delete Existing Purchase Details
        $purchaseMaster->details()->delete();

        // **Update Purchase Master Data**
        $purchaseMaster->supplier_id = $request->supplier_id;
        $purchaseMaster->purchase_date = $request->purchase_date;
        $purchaseMaster->total_quantity = array_sum($request->quantity);
        $purchaseMaster->total_amount = array_sum(array_map(function ($quantity, $price) {
            return $quantity * $price;
        }, $request->quantity, $request->purchase_price));
        $purchaseMaster->updated_by = auth()->id();
        $purchaseMaster->save();

        // **Insert New Purchase Details**
        foreach ($request->medicine_id as $index => $medicineId) {
            $details = new PurchaseDetails();
            $details->purchase_master_id = $purchaseMaster->id;
            $details->medicine_id = $medicineId;
            $details->unit_id = $request->unit_id[$index];
            $details->purchase_price = $request->purchase_price[$index];
            $details->quantity = $request->quantity[$index];
            $details->total = $details->purchase_price * $details->quantity;
            $details->save();

            // **Update Medicine Stock**
            $medicine = Medicine::find($medicineId);
            if ($medicine) {
                $medicine->stock += $request->quantity[$index]; // Adding updated stock
                $medicine->save();
            }
        }

        Toastr::success('Success', 'Purchase updated successfully!');
        return redirect()->route('purchases.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $purchaseMaster = PurchaseMaster::findOrFail($id);

        // Restore Stock Before Deleting
        foreach ($purchaseMaster->details as $detail) {
            $medicine = Medicine::find($detail->medicine_id);
            if ($medicine) {
                $medicine->stock -= $detail->quantity; // Reduce stock
                $medicine->save();
            }
        }

        // Delete Related Purchase Details
        $purchaseMaster->details()->delete();

        // Delete Purchase Master Record
        $purchaseMaster->delete();

        Toastr::success('Success', 'Purchase deleted successfully!');
        return redirect()->route('purchases.index');
    }
}
