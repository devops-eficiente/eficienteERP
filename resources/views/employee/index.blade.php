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
        <a href="{{ route('admin.validationRfc') }}" class="btn bg-secondary text-white">
            Validacion masiva
        </a>
        @livewire('employee.upload-zip')
    </div>
    <div class="card">
        <div class="card-header">

            <div class="flex justify-between items-center">
                <h4 class="card-title">Empleados</h4>
            </div>
        </div>
        <div class="p-6 card-body">
            <div class="overflow-y-auto overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overscroll-y-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 overscroll-y-auto">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        N. Empleado
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        CURP
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        RFC
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Observaciones
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Accion
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($persons as $person)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                            {{ $person->employee->n_employee }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                            {{ $person->employee->name }} {{ $person->employee->paternal_surname }}
                                            {{ $person->employee->maternal_surname }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                            {{ $person->employee->curp }}
                                        </td>
                                        @if (!$person->employee->rfc_verified)
                                            <td
                                                class=" flex flex-col gap-3 px-6 py-4 whitespace-nowrap text-sm items-center justify-center">
                                                <span class="text-white bg-red-500 rounded-xl px-4 py-1">
                                                    {{ $person->rfc }}
                                                </span>
                                                <p class="text-xs text-center">
                                                    No verificado
                                                    <i class="mgc_close_fill"></i>
                                                </p>
                                            </td>
                                        @else
                                            <td
                                                class=" flex flex-col gap-3 px-6 py-4 whitespace-nowrap text-sm text-green-800 items-center justify-center">
                                                {{ $person->rfc }}
                                                <p class="text-xs text-center">
                                                    Verificado
                                                    <i class="mgc_check_2_fill"></i>
                                                </p>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                            SAT: {{ $person->comments ?? 'N/A' }}
                                            <br>
                                            @if (!$person->employee->complete)
                                                Perfil incompleto
                                            @endif
                                            <br>
                                            @if (!$person->employee->rfc_verified)
                                                RFC no verificado
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex flex-col gap-4">
                                                @if (!$person->employee->rfc_verified)
                                                    @livewire('employee.upload-document', ['person' => $person])
                                                @endif
                                                <div>
                                                    <a class="btn rounded-full border border-success text-success hover:bg-success hover:text-white"
                                                        href="{{ route('admin.show_employee', $person->rfc) }}">
                                                        Ver
                                                    </a>
                                                    <a href="{{ route('admin.edit_employee', $person->rfc) }}"
                                                        class="btn rounded-full border border-info text-info hover:bg-info hover:text-white">
                                                        Editar
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer p-6">
            {{ $persons->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
