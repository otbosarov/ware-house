<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ID' => $this->id,
            'Tovar_nomi' =>$this->title,
            'Kategoriya' => $this->productCategory->category_title,
            'Brend' => $this->productBrend->brend_title,
            'Tovar_yaratgan_foydalanuvchi' => $this->productUser->full_name,
            'Yaratilgan_sana' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
