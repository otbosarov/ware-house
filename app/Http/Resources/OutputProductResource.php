<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OutputProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ID' => $this->product_variant_id,
            'Tovar_nomi' => $this->product_variant_title,
            'Miqdori' => $this->output_quantity,
            'Sotish_narxi' => $this->output_selling_price,
            'Chiqim_sanasi' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
