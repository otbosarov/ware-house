<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'residue',
        'input_price',
        'selling_price',
        'raise',
        'old_selling_price',
    ];
    public function Product_Variant_Detail(){
        return $this->hasOne(ProductVariant::class,'id','product_variant_id');
      }
}
