<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyEditRequest extends FormRequest
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
        $company = $this->route('company');
        return [
            'bussines_name' => [
                'required',
                'unique:companies,bussines_name,'.$company->id,
            ],
            'rfc' => [
                'required',
                'unique:companies,rfc,'.$company->id
            ],
            'email' => [
                'required',
                'unique:companies,email,'.$company->id
            ],
            'telephone' => [
                'required',
                'unique:companies,phone,'.$company->id
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
            'modules' => 'modulos'
        ];
    }
}
