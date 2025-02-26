<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSalesMaster extends Model
{
    use HasFactory;

    public function testSalesDetails()
    {
        return $this->hasMany(TestSalesDetail::class, 'test_sale_master_id');
    }
    
    // Relationship with Patient (if you have a Patient model)
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}
