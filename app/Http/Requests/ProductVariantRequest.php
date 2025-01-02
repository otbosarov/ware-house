<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
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
            'product_variant_title'=>'required|string|min:3|max:255',
            'product_id'=>'required|integer|min:1|exists:products,id',
            'color'=>'required|string|min:2|max:255|nullable',
            'internal_memory'=>'nullable|string|min:2|max:255|nullable',
            'weight'=>'nullable|string|min:1|max:255|nullable',
        ];
    }
    public function messages(){
        return [
            'product_variant_title.required' => "Mahsulot varianti nomi majburiy.",
            'product_variant_title.string' => "Mahsulot varianti nomi matn bo'lishi kerak.",
            'product_variant_title.min' => "Mahsulot varianti nomi kamida 3 belgidan iborat bo'lishi kerak.",
            'product_variant_title.max' => 'Mahsulot varianti nomi 255 belgidan oshmasligi kerak.',

            'product_id.required' => "Mahsulot ID majburiy.",
            'product_id.integer' => "Mahsulot ID butun son bo'lishi kerak.",
            'product_id.min' => "Mahsulot ID kamida 1 bo'lishi kerak.",
            'product_id.exists' => "Ko'rsatilgan mahsulot mavjud emas.",

            'color.required' => 'Mahsulot rangi majburiy.',
            'color.string' => "Mahsulot rangi matn bo'lishi kerak.",
            'color.min' => "Mahsulot rangi kamida 2 belgidan iborat bo'lishi kerak.",
            'color.max' => "Mahsulot rangi 255 belgidan oshmasligi kerak.",

            'internal_memory.required' => 'Ichki xotira majburiy.',
            'internal_memory.string' => "Ichki xotira matn bo'lishi kerak.",
            'internal_memory.min' => "Ichki xotira kamida 2 belgidan iborat bo'lishi kerak.",
            'internal_memory.max' => "Ichki xotira 255 belgidan oshmasligi kerak.",

            'weight.required' => "Mahsulot og'irligi majburiy.",
            'weight.string' => "Mahsulot og'irligi matn bo'lishi kerak.",
            'weight.min' => "Mahsulot og'irligi kamida 1 belgidan iborat bo'lishi kerak.",
            'weight.max' => "Mahsulot og'irligi 255 belgidan oshmasligi kerak.",
        ];
    }
}
