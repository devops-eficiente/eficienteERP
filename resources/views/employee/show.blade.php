@extends('layouts.vertical')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Eficiente ERP</h4>
        <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
            <div class="flex items-center gap-2">
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Eficiente</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Empleados</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">
                    Todos los empleados
                </a>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row my-4 justify-around items-center w-full">
        <a href="#" class="btn bg-secondary text-white">
            Editar
        </a>
        <a href="{{ route('admin.employees') }}" class="btn bg-info text-white">
            Regresar
        </a>
    </div>
    <div class="grid md:grid-cols-3 grid-cols-1 gap-5">
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Empleado No. {{ $person->employee->n_employee }}</h4>
                </div>
            </div>
            <div class=" flex flex-col card-body py-4 gap-5">
                <h2 class="text-center mb-2 text-gray-800">
                    Nombre:
                    {{ $person->employee->name }} {{ $person->employee->paternal_surname }}
                    {{ $person->employee->maternal_surname }}
                </h2>
                <h2 class="text-center mb-2 text-gray-800">
                    RFC:
                    {{ $person->rfc }}
                </h2>
                <h2 class="text-center mb-2 text-gray-800">
                    CURP:
                    {{ $person->employee->curp }}
                </h2>
                @if ($person->employee->institute_health_id)
                    <h2 class="text-center mb-2 text-gray-800">
                        Seguro:
                        {{ $person->employee->institute_health->acronym }}
                        <br>
                        NSS: {{ $person->employee->nss }}
                    </h2>
                @endif
                @if ($person->employee->identification_employee)
                    <h2 class="text-center mb-2 text-gray-800">
                        Tipo de identificación:
                        {{ $person->employee->identification_employee->name }}
                        <br>
                        Número: {{ $person->employee->n_identification }}
                    </h2>
                @endif
                <h2 class="text-center mb-2 text-gray-800">
                    Genero:
                    {{ $person->employee->gender }}
                </h2>
                <h2 class="text-center mb-2 text-gray-800">
                    Nacionalidad:
                    {{ $person->employee->nationality }}
                </h2>
                <h2 class="text-center mb-2 text-gray-800">
                    Nacimiento:
                    {{ $person->employee->birthdate }}
                </h2>
                @if ($person->employee->marital_status)
                    <h2 class="text-center mb-2 text-gray-800">
                        Estado civil:
                        {{ $person->employee->marital_status->name }}
                    </h2>
                @endif
                @if ($person->employee->blood_type)
                    <h2 class="text-center mb-2 text-gray-800">
                        Grupo sanguineo:
                        {{ $person->employee->blood_type->name }}
                    </h2>
                @endif
            </div>

        </div>
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Direcciones</h4>
                </div>
            </div>
            <div class="flex flex-col card-body py-4 gap-5">
                @foreach ($person->addresses as $address)
                    <h2 class="text-center mb-2 text-gray-800">
                        Estado:
                        {{ $address->state ?? 'N/A' }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Ciudad:
                        {{ $address->city ?? 'N/A' }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Codigo postal:
                        {{ $address->zip_code }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Colonia:
                        {{ $address->suburb ?? 'N/A' }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Tipo Vialidad:
                        {{ $address->road_type ?? 'N/A' }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Nombre Vialidad:
                        {{ $address->road_name ?? 'N/A' }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Número interior:
                        {{ $address->internal_number ?? 'N/A' }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Número exterior:
                        {{ $address->external_number ?? 'N/A' }}
                    </h2>
                    <hr>
                @endforeach
            </div>

        </div>
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Regimen Fiscal</h4>
                </div>
            </div>
            <div class="flex flex-col card-body py-4 gap-5">
                @foreach ($person->tax_regimes as $taxRegime)
                    <h2 class="text-center mb-2 text-gray-800">
                        Código:
                        {{ $taxRegime->code ?? 'N/A' }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Nombre:
                        {{ $taxRegime->name ?? 'N/A' }}
                    </h2>
                    <h2 class="text-center mb-2 text-gray-800">
                        Estado del padron:
                        {{ $taxRegime->pivot->status ? 'Activo' : 'Inactivo' }}
                    </h2>
                    <hr>
                @endforeach
            </div>

        </div>
    </div>
@endsection
