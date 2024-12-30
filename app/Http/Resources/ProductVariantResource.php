<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ID' => $this->product_id,
            'Tovar_variant_nomi' => $this->product_variant_title,
            'Rangi' => $this->color,
            'Ichki_xotira' => $this->internal_memory,
            "Og'irligi" => $this->weight,
            'Yaratilgan_sana' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
