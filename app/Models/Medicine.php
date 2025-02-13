<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcat()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
  
}
