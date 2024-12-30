<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'output_quantity',
        'output_selling_price',
    ];
    public function Product_Variant(){
        return $this->hasOne(ProductVariant::class,'id','product_variant_id');
      }
}
