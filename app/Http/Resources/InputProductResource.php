<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputProductResource extends JsonResource
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
            'Valyuta_turi' => $this->currency_type,
            'Kirim_narxi' => $this->input_price,
            'Miqdori' => $this->amount,
            'Kirim_sanasi' =>$this->created_at->format('Y-m-d')
        ];
    }
}
