<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'input_price',
        'currency_type',
        'amount',
    ];
    public function Product_Variant(){
      return $this->hasOne(ProductVariant::class,'id','product_variant_id');
    }
    
}
