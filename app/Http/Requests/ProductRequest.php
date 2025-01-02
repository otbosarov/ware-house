<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'product_category_id' => 'required|integer|exists:categories,id',
            'product_brend_id' => 'required|integer|exists:brends,id',
        ];
    }
    public function messages(){
        return [
            'title.required' => 'Mahsulot nomi kiritilishi shart.',
            'title.string' => 'Mahsulot nomi matn bo\'lishi kerak.',
            'title.min' => 'Maxsulot nommi kamida 3 ta belgidan iborat bo\'lsin',
            'title.max' => 'Mahsulot nomi 255 belgidan oshmasligi kerak.',
            'product_category_id.required' => 'Mahsulot kategoriyasi tanlanishi shart.',
            'product_category_id.integer' => 'Mahsulot kategoriyasi ID butun son bo\'lishi kerak.',
            'product_category_id.exists' => 'Ko\'rsatilgan mahsulot kategoriyasi mavjud emas.',
            'product_brend_id.required' => 'Mahsulot brendi tanlanishi shart.',
            'product_brend_id.integer' => 'Mahsulot brendi ID butun son bo\'lishi kerak.',
            'product_brend_id.exists' => 'Ko\'rsatilgan mahsulot brendi mavjud emas.',
        ];
    }
}
