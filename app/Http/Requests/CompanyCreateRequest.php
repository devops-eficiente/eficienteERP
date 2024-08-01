<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bussines_name' => [
                'required',
                'unique:companies,bussines_name',
            ],
            'rfc' => [
                'required',
                'unique:companies,rfc'
            ],
            'email' => [
                'required',
                'unique:companies,email'
            ],
            'telephone' => [
                'required',
                'unique:companies,phone'
            ],
            'user_name' => [
                'required',
            ],
            'user_email' => [
                'required',
                'unique:users,email'
            ],
            'user_password' => [
                'required'
            ],
            'modules' => [
                'required'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'bussines_name' => 'nombre empresa',
            'email' => 'correo',
            'telephone' => 'telefono',
            'user_name' => 'nombre usuario',
            'user_email' => 'correo usuario',
            'user_password' => 'contraseña',
            'modules' => 'modulos'
        ];
    }
}
