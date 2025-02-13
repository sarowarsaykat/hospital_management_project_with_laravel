<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;

    public function master()
    {
        return $this->belongsTo(PurchaseMaster::class, 'purchase_master_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
