<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantDetailRequest extends FormRequest
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
            'selling_price' => 'nullable|numeric|min:0|max:1000000000',
            'raise' => 'nullable|numeric|min:0|max:100',

        ];
    }
    public function messages(){
        return [
            'product_variant_id.required' => 'Mahsulot variant ID majburiy.',
            'product_variant_id.integer' => 'Mahsulot variant ID butun son bo\'lishi kerak.',
            'product_variant_id.exists' => 'Ko\'rsatilgan mahsulot variant ID mavjud emas.',
            'selling_price.numeric' => 'Sotish narxi faqat son bo\'lishi kerak.',
            'selling_price.min' => 'Sotish narxi 0 dan kam bo\'lmasligi kerak.',
            'selling_price.max' => 'Sotish narxi 1 milliarddan oshmasligi kerak.',
            'raise.numeric' => 'Ustama faqat son bo\'lishi kerak.',
            'raise.min' => 'Ustama 0 dan kam bo\'lmasligi kerak.',
            'raise.max' => "Ustama 100 dan oshmasligi kerak.",
        ];
    }
}
