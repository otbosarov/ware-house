<?php

namespace App\Http\Requests;

use App\Models\Brend;
use Illuminate\Foundation\Http\FormRequest;

class BrendRequest extends FormRequest
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
            'brend_title' => 'required|string|min:2|max:120|unique:brends,brend_title'
        ];
    }
    public function messages(){
        return [
            'brend_title.required' => 'Brend nomini kirting',
            'brend_title.string' => 'Brend nomi matn ko\'rinishida bo\'lsin',
            'brend_title.min' => "Brend nomi kamida 2 belgidan iborat bo'lishi kerak",
            'brend_title.max' => "Brend nomi 120 ta belgidan oshmasligi kerak",
            'brend_title.unique' => "Bu Brend avval yaratilgan "
        ];
    }
}
