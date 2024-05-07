<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
            'company_name' => 'required',
            'capital_regime_id' => 'required|exists:capital_regimes,id',
            'rfc' => [
                'required',
                'unique:persons',
                'regex:/^([A-Z&Ññ]{3,4})((\d{2})(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01]))(([A-Z\d]{2})(\d|[A]))?$/i'
            ],
            'tax_regimes' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'zip_code' => 'required|digits:5',
            'regimen' => 'in:fisica,moral',
        ];
    }
    public function attributes(): array
    {
        return [
            'company_name' => 'Razón social',
            'capital_regime_id' => 'Regimen de capital',
            'tax_regimes' => 'Regimen Fiscal',
            'email' => 'correo',
            'phone' => 'telefono',
            'regimen' => 'tipo de regimen',
        ];
    }
}
