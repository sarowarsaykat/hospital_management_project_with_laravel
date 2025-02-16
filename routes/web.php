<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PathologicalTestController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::middleware(['auth'])->group(function () {
    Route::get("/", [AdminController::class, "home"]);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('doctors', DoctorController::class);
    Route::resource('nurses', NurseController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('pathological-tests', PathologicalTestController::class);
    Route::resource('category',CategoryController::class);
    Route::resource('sub-categories', SubCategoryController::class);
    Route::resource('manufacturer',ManufacturerController::class);
    Route::resource('units', UnitController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', SalesController::class); 
    Route::get('/medicine-details/{id}', [MedicineController::class, 'getMedicineDetails']);

});
