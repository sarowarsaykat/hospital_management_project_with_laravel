<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;

    public function salesMaster()
    {
        return $this->belongsTo(SalesMaster::class);
    }

    
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);  
    }
}
