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
            'raise' => 'nullable|numeric|between:1,100',
        ];
    }
    public function messages(){
        return [
            'raise.numeric' => 'Ustama faqat son bo\'lishi kerak.',
            'raise.between' => 'Tovar  ustamani 1 dan 100 gacha bo\'lgan sonlarni qabul qiladi'
        ];
    }
}
