<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Nurse;
use App\Models\PathologicalTest;
use App\Models\Patient;
use App\Models\PurchaseMaster;
use App\Models\SalesMaster;
use App\Models\Supplier;
use App\Models\TestSalesMaster;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        $data = [
            "doctorCount" => Doctor::count(),
            "nurseCount" => Nurse::count(),
            "patientCount" => Patient::count(),
            "supplierCount" => Supplier::count(),
            "customerCount" => Customer::count(),
            "purchaseMedicineCount" => PurchaseMaster::count(),
            "medicineSalesCount" => SalesMaster::count(),
            "totalMedicines" => Medicine::count(),
            "totalTests" => PathologicalTest::count(),
            "testSalesCount" => TestSalesMaster::count(),
        ];


        return view( 'home',$data );
    }
}
