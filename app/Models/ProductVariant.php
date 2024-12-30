<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_title',
        'product_id',
        'color',
        'internal_memory',
        'weight',
        'active',
    ];
}
