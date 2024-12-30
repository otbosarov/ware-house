<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'full_name' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:4|max:255'
        ];
    }
    public function messages(){
        return [
            'full_name.required' => "To'liq ism kiriting",
            'full_name.string'=> "To'liq ism matn ko'rinishda kiriting",
            'full_name.min' => "To'liq ism kamida 3 ta belgidan iborat bo'lsin ",
            'full_name.max' => "To'liq ism 255 ta belgidan oshmasligi kerak ",
            'username.required' => "Username kiriting",
            'username.string' => "Username matn ko'rinishda kiriting",
            'username.min' => "Username kamida 3 ta belgidan iborat bo'lsin",
            'username.max' => "Username 255 ta belgidan oshmasligi kerak ",
            'password.required' => "Parolni kiriting ",
            'password.min' => "Parol kamida 4 ta belgidan iborat bolishi kerak ",
            'password.max' => "Parol 255 ta belgidan oshmaskigi kerak"
        ];
    }
}
