@extends('layouts.vertical')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <h4 class="text-lg font-medium text-slate-900 dark:text-slate-200">Eficiente ERP</h4>
        <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
            <div class="flex items-center gap-2">
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Eficiente</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="flex-shrink-0 text-lg mgc_right_line text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">WhatsApp</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="flex-shrink-0 text-lg mgc_right_line text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">
                    Todas las sesiones
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">

            <div class="flex items-center justify-between">
                <h4 class="card-title">Sesiones</h4>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto overflow-y-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overscroll-y-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 overscroll-y-auto">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-center text-gray-500 uppercase">
                                        Número
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-center text-gray-500 uppercase">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-center text-gray-500 uppercase">
                                        Inicio de conversación
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-center text-gray-500 uppercase">
                                        Ultima actualización
                                    </th>
                                    {{-- <th scope="col"
                                        class="px-6 py-3 font-medium text-center text-gray-500 uppercase ext-xs">
                                        Accion
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($whatsappSessions as $whatsappSession)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-center text-gray-800 whitespace-nowrap">
                                            {{ $whatsappSession->phone }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-800 whitespace-nowrap">
                                            {{ $whatsappSession->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-800 whitespace-nowrap">
                                            {{ $whatsappSession->created_at->format('d-m-Y H:i A') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-800 whitespace-nowrap">
                                            {{ $whatsappSession->step->updated_at->format('d-m-Y H:i A') }}
                                        </td>
                                        {{-- <td class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    @livewire('whatsapp-conversation', ['step' => $whatsappSession->step])
                                                </div>

                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
