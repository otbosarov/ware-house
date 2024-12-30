<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->product_variant_id,
            'product_name'=>$this->product_variant_title,
            'category_name'=>$this->category_title,
            'brand'=> $this->brend_title,
            'raise' =>$this->raise,
            'selling_price'=>$this->selling_price,
            'old_selling_price' =>$this->old_selling_price,
            'residue' => $this->residue,
        ];
    }
}
