<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'product_category_id',
        'product_brend_id',
        'user_id',
        'active',
    ];
    public function productBrend()
    {
        return $this->hasOne(Brend::class, 'id', 'product_brend_id');
    }
    public function productCategory()
    {
        return $this->hasOne(Category::class, 'id', 'product_category_id');
    }
    public function productUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
