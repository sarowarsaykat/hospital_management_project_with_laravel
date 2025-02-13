<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMaster extends Model
{
    use HasFactory;

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
