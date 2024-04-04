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
                    Verificar Empleado
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h4 class="card-title">Verificar datos</h4>
            </div>
        </div>
        @php
            $cont = 0;
        @endphp
        <div class="p-6">
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overscroll-y-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 overscroll-y-auto">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Campo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Datos guardados en la base local
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Datos Obtenidos en el SAT
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        Nombre
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $employee->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($employee->name, $persona->nombre) !== 0)
                                            <i class="mgc_close_fill text-lg text-green-700"></i>
                                            @php
                                                $cont++;
                                            @endphp
                                        @else
                                            <i class="mgc_check_fill text-lg text-green-700"></i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        Apellido paterno
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $employee->paternal_surname }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->apellido_paterno }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($employee->paternal_surname, $persona->apellido_paterno) !== 0)
                                            <i class="mgc_close_fill text-lg text-green-700"></i>
                                            @php
                                                $cont++;
                                            @endphp
                                        @else
                                            <i class="mgc_check_fill text-lg text-green-700"></i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        Apellido materno
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $employee->maternal_surname }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->apellido_materno }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($employee->maternal_surname, $persona->apellido_materno) !== 0)
                                            <i class="mgc_close_fill text-lg text-green-700"></i>
                                            @php
                                                $cont++;
                                            @endphp
                                        @else
                                            <i class="mgc_check_fill text-lg text-green-700"></i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        Codigo Postal
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $employee->zip_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->codigo_postal }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($employee->zip_code, $persona->codigo_postal) !== 0)
                                            <i class="mgc_close_fill text-lg text-green-700"></i>
                                            @php
                                                $cont++;
                                            @endphp
                                        @else
                                            <i class="mgc_check_fill text-lg text-green-700"></i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        CURP
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $employee->curp }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->curp }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($employee->curp, $persona->curp) !== 0)
                                            <i class="mgc_close_fill text-lg text-green-700"></i>
                                            @php
                                                $cont++;
                                            @endphp
                                        @else
                                            <i class="mgc_check_fill text-lg text-green-700"></i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        RFC
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $employee->rfc }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->rfc }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($employee->rfc, $persona->rfc) !== 0)
                                            <i class="mgc_close_fill text-lg text-green-700"></i>
                                            @php
                                                $cont++;
                                            @endphp
                                        @else
                                            <i class="mgc_check_fill text-lg text-green-700"></i>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-around my-3">
        <a href="{{ route('admin.employees') }}" class="btn bg-secondary text-white">Regresar</a>
        @if ($cont == 0)
            <a href="{{ route('admin.continue_employee') }}" class="btn bg-success text-white">Continuar</a>
        @else
            <a href="{{ route('admin.edit_data_employee') }}" class="btn bg-warning text-white">Corregir errores</a>
        @endif
    </div>
@endsection
