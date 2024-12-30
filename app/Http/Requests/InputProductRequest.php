<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InputProductRequest extends FormRequest
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
            'input_price' => 'required|numeric|min:0',
            'currency_type' => 'required|string|in:USD,UZS',
            'amount' => 'required|integer|min:1',
        ];
    }
    public function messages()
    {
        return [
            'product_variant_id.required' => "Mahsulot variant ID majburiy.",
            'product_variant_id.integer' => "Mahsulot variant ID butun son bo'lishi kerak.",
            'product_variant_id.exists' => "Ko'rsatilgan mahsulot varianti mavjud emas.",

            'input_price.required' => "Narxni kiritish majburiy.",
            'input_price.numeric' => "Narx raqam bo'lishi kerak.",
            'input_price.min' => "Narx manfiy bo'lmasligi kerak.",

            'currency_type.required' => "Valyuta turi majburiy.",
            'currency_type.string' => "Valyuta turi matn bo'lishi kerak.",

            'amount.required' => "Miqdor majburiy.",
            'amount.integer' => "Miqdor butun son bo'lishi kerak.",
            'amount.min' => "Miqdor kamida 1 bo'lishi kerak.",
        ];
    }
}
