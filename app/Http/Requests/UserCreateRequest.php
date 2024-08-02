<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => [
                'required',
            ],
            'email' => [
                'required',
                'unique:users,email'
            ],
            'password' => [
                'required'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre usuario',
            'email' => 'correo usuario',
            'password' => 'contraseña',
        ];
    }
}
