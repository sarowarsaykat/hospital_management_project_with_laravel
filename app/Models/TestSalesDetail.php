<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSalesDetail extends Model
{
    use HasFactory;

    public function testSalesMaster()
    {
        return $this->belongsTo(TestSalesMaster::class, 'test_sale_master_id');
    }

    // Relationship with PathologicalTest

    public function pathologicalTest()
    {
        return $this->belongsTo(PathologicalTest::class, 'test_id');
    }
    

}
