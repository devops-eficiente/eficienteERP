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
                                        RFC
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->rfc }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->rfc }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->rfc, $persona->rfc) !== 0)
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
                                        Nombre
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->employee->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->employee->name, $persona->nombre) !== 0)
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
                                        {{ $person->employee->paternal_surname }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->apellido_paterno }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->employee->paternal_surname, $persona->apellido_paterno) !== 0)
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
                                        {{ $person->employee->maternal_surname }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->apellido_materno }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->employee->maternal_surname, $persona->apellido_materno) !== 0)
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
                                        {{ $person->employee->curp }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->curp }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->employee->curp, $persona->curp) !== 0)
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
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-bold">
                                        Direcciones del empleado
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-bold">

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        Codigo Postal
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->addresses[0]->zip_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->codigo_postal }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->addresses[0]->zip_code, $persona->codigo_postal) !== 0)
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
                                        Estado
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->addresses[0]->state ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->entidad_federativa }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->addresses[0]->state, $persona->entidad_federativa) !== 0)
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
                                        Ciudad
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->addresses[0]->city ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->municipio_delegacion }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->addresses[0]->city, $persona->municipio_delegacion) !== 0)
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
                                        Tipo de vialidad
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->addresses[0]->road_type ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->tipo_vialidad }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->addresses[0]->road_type, $persona->tipo_vialidad) !== 0)
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
                                        Nombre de vialidad
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->addresses[0]->road_name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->nombre_vialidad }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->addresses[0]->road_name, $persona->nombre_vialidad) !== 0)
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
                                        Numero interior
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->addresses[0]->internal_number ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->numero_interior }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->addresses[0]->internal_number, $persona->numero_interior) !== 0)
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
                                        Numero exterior
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->addresses[0]->external_number ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->numero_exterior }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->addresses[0]->external_number, $persona->numero_exterior) !== 0)
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
                                        Colonia
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $person->addresses[0]->suburb ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $persona->colonia }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if (strcasecmp($person->addresses[0]->suburb, $persona->colonia) !== 0)
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
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-bold">Regimen
                                        fiscales</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        Colonia
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        @if ($person->tax_regimes->isNotEmpty())
                                            @foreach ($person->tax_regimes as $taxRegime)
                                                {{ $taxRegime->code }} - {{ $taxRegime->name ?? 'N/A' }}
                                                <br>
                                            @endforeach
                                        @else
                                            N/A
                                        @endif
                                        {{-- {{ $person->tax_regimes->count() ?? 0 }} --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        @foreach ($persona->regimenes as $regimen)
                                            {{ $regimen->regimen_id }} - {{ $regimen->regimen }}
                                            <br>
                                            {{-- {{ collect($persona->regimenes)->count() }} --}}
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if ($person->tax_regimes->count() > 0)
                                            @if ($person->tax_regimes->count() == collect($persona->regimenes)->count())
                                                <i class="mgc_check_fill text-lg text-green-700"></i>
                                            @else
                                                <i class="mgc_close_fill text-lg text-green-700"></i>
                                                @php
                                                    $cont++;
                                                @endphp
                                            @endif
                                        @else
                                            <i class="mgc_close_fill text-lg text-green-700"></i>
                                            @php
                                                $cont++;
                                            @endphp
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
            <a href="{{ route('admin.employee.continue_employee') }}" class="btn bg-success text-white">Continuar</a>
        @else
            <a href="{{ route('admin.employee.edit_data_employee') }}" class="btn bg-warning text-white">Corregir errores</a>
        @endif
    </div>
@endsection
