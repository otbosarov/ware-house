<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutputProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_variant_id' => 'required|integer|exists:product_variants,id',
            'output_quantity' => 'required|integer|min:1'
        ];
    }
    public function messages(){
        return [
                 'product_variant_id.required' => "Mahsulot variant ID majburiy.",
                 'product_variant_id.integer' => "Mahsulot variant ID butun son bo'lishi kerak.",
                 'product_variant_id.exists' => "Ko'rsatilgan mahsulot varianti mavjud emas.",
                 'output_quantity.required' => "Miqdor majburiy.",
                 'output_quantity.integer' => "Miqdor butun son bo'lishi kerak.",
                 'output_quantity.min' => "Miqdor kamida 1 bo'lishi kerak.",

        ];
    }
}
