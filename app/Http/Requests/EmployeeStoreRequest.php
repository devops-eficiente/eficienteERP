<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'rfc' => 'required|unique:employees',
            'curp' => 'required|unique:employees',
            'nss' => 'required|unique:employees',
            'name' => 'required',
            'paternal_surname' => 'required',
            'maternal_surname' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'birthdate' => 'required',
            'identification_employee_id' => 'required|exists:identification_employees,id',
            'blood_type_id' => 'required|exists:blood_types,id',
            'marital_status_id' => 'required|exists:marital_status,id',
            'institute_health_id' => 'required|exists:institute_healths,id',
            'n_identification' => 'required',
            'contacts.email' => 'required|email',
            'contacts.telephone' => 'required|digits:10',
            'contacts.phone' => 'required|digits:10',
            'emergency_contacts.name' => 'required',
            'emergency_contacts.phone' => 'required|digits:10',
            'zip_code' => 'nullable|digits:5',
        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'gender' => 'genero',
            'nationality' => 'nacionalidad',
            'birthdate' => 'fecha nacimiento',
            'identification_employee_id' => 'tipo de identificacion',
            'blood_type_id' => 'tipo de sangre',
            'marital_status_id' => 'estado civil',
            'institute_health_id' => 'institucion de salud',
            'n_identification' => 'número de identificación',
            'paternal_surname' => 'apellido paterno',
            'maternal_surname' => 'apellido materno',
            'contacts.email' => 'correo de contacto',
            'contacts.telephone' => 'telefono de contacto',
            'contacts.phone' => 'celular de contacto',
            'emergency_contacts.name' => 'nombre de emergencia',
            'emergency_contacts.phone' => 'número de emergencia',
            'zip_code' => 'codigo postal',
        ];
    }
}
