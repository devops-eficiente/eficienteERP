@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Eficiente ERP</h4>
        <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
            <div class="flex items-center gap-2">
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Eficiente</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Inicio</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400"
                    aria-current="page">Dashboard</a>
            </div>
        </div>
    </div>
    <div class="grid 2xl:grid-cols-4 gap-6 mb-6">

        {{-- SUMATORIAS RESUMENES --}}


        <div class="2xl:col-span-3">

            <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6 mb-6">
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Gastos</h4>
                                <p class="font-normal text-sm text-gray-400 truncate dark:text-gray-500">$20000</p>
                            </div>
                        </div>

                        <div class="flex items-end">
                            <div class="flex-grow">
                                <p class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold"><i
                                        class="mgc_alarm_2_line"></i> Hace 1 dia</p>
                            </div>
                            <div class="flex">
                                <a href="javascript:void(0);">
                                   <i class="mgc_currency_dollar_2_line text-3xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Ventas</h4>
                                <p class="font-normal text-sm text-gray-400 truncate dark:text-gray-500">$20000</p>
                            </div>
                        </div>

                        <div class="flex items-end">
                            <div class="flex-grow">
                                <p class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold"><i
                                        class="mgc_alarm_2_line"></i> Hace 1 dia</p>
                            </div>
                            <div class="flex">
                                <a href="javascript:void(0);">
                                   <i class="mgc_wallet_2_fill text-3xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Compras</h4>
                                <p class="font-normal text-sm text-gray-400 truncate dark:text-gray-500">$20000</p>
                            </div>
                        </div>

                        <div class="flex items-end">
                            <div class="flex-grow">
                                <p class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold"><i
                                        class="mgc_alarm_2_line"></i> Hace 1 dia</p>
                            </div>
                            <div class="flex">
                                <a href="javascript:void(0);">
                                   <i class="mgc_shopping_bag_3_fill text-3xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-base mb-1 text-gray-600 dark:text-gray-400">Cobros</h4>
                                <p class="font-normal text-sm text-gray-400 truncate dark:text-gray-500">$20000</p>
                            </div>
                        </div>

                        <div class="flex items-end">
                            <div class="flex-grow">
                                <p class="text-[13px] text-gray-400 dark:text-gray-500 font-semibold"><i
                                        class="mgc_alarm_2_line"></i> Hace 1 dia</p>
                            </div>
                            <div class="flex">
                                <a href="javascript:void(0);">
                                   <i class="mgc_receive_money_fill text-3xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">

                {{-- GRAFICA DE PASTEL --}}

                <div class="col-span-1">
                    <div class="card">
                        <div class="p-6">
                            <h4 class="card-title">Ingresos / Egresos</h4>

                            <div id="monthly-target" class="apex-charts my-8" data-colors="#0acf97,#3073F1" data-datos="3500.58,1200.26"></div>

                            <div class="flex justify-center">
                                <div class="w-1/2 text-center">
                                    <h5>Total</h5>
                                    <p class="fw-semibold text-muted">
                                        <i class="mgc_round_fill text-primary"></i> Egresos
                                    </p>
                                </div>
                                <div class="w-1/2 text-center">
                                    <h5>Total</h5>
                                    <p class="fw-semibold text-muted">
                                        <i class="mgc_round_fill text-success"></i> Ingresos
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- GRAFICA DE BARRAS --}}
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="p-6">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">Gastos e Ingresos</h4>
                                <div class="flex gap-2">
                                    <button type="button"
                                        class="btn btn-sm bg-primary/25 text-primary hover:bg-primary hover:text-white">
                                        All
                                    </button>
                                    <button type="button"
                                        class="btn btn-sm bg-gray-400/25 text-gray-400 hover:bg-gray-400 hover:text-white">
                                        6M
                                    </button>
                                    <button type="button"
                                        class="btn btn-sm bg-gray-400/25 text-gray-400 hover:bg-gray-400 hover:text-white">
                                        1Y
                                    </button>
                                </div>
                            </div>

                            <div dir="ltr" class="mt-2">
                                <div id="crm-project-statistics" class="apex-charts" data-colors="#ffee61,#3073F1" data-expenses="" data-income="" data-months=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAREAS PENDIENTES --}}
        <div class="col-span-1">
            <div class="card mb-6">
                <div class="px-6 py-5 flex justify-between items-center">
                    <h4 class="header-title">Tareas Pendientes</h4>
                    {{-- <div>
                        <button class="text-gray-600 dark:text-gray-400" data-fc-type="dropdown" data-fc-placement="left-start" type="button">
                            <i class="mgc_more_1_fill text-xl"></i>
                        </button>

                        <div class="hidden fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-36 z-50 mt-2 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg p-2">
                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" href="javascript:void(0)">
                                <i class="mgc_add_circle_line"></i> Add
                            </a>
                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200" href="javascript:void(0)">
                                <i class="mgc_edit_line"></i> Edit
                            </a>
                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:void(0)">
                                <i class="mgc_copy_2_line"></i> Copy
                            </a>
                            <div class="h-px bg-gray-200 dark:bg-gray-700 my-2 -mx-2"></div>
                            <a class="flex items-center gap-1.5 py-1.5 px-3.5 rounded text-sm transition-all duration-300 bg-transparent text-danger hover:bg-danger/5" href="javascript:void(0)">
                                <i class="mgc_delete_line"></i> Delete
                            </a>
                        </div>
                    </div> --}}
                </div>
                <div class="px-4 py-2 bg-warning/20 text-warning" role="alert">
                    <i class="mgc_folder_star_line me-1 text-lg align-baseline"></i> <b>38</b> Total Admin & Client
                    Projects
                </div>

                <div class="p-6 space-y-3">
                    <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                        <div class="flex-shrink-0 me-2">
                            <div
                                class="w-12 h-12 flex justify-center items-center rounded-full text-primary bg-primary/25">
                                <i class="mgc_group_line text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h5 class="font-semibold mb-1">Tarea 1</h5>
                            <p class="text-gray-400">6 Person</p>
                        </div>
                        <div>
                            <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                                <i class="mgc_information_line text-xl"></i>
                            </button>
                            <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50"
                                role="tooltip">
                                Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                        <div class="flex-shrink-0 me-2">
                            <div
                                class="w-12 h-12 flex justify-center items-center rounded-full text-warning bg-warning/25">
                                <i class="mgc_compass_line text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h5 class="fw-semibold my-0">In Progress</h5>
                            <p>16 Projects</p>
                        </div>
                        <div>
                            <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                                <i class="mgc_information_line text-xl"></i>
                            </button>
                            <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50"
                                role="tooltip">
                                Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                        <div class="flex-shrink-0 me-2">
                            <div class="w-12 h-12 flex justify-center items-center rounded-full text-danger bg-danger/25">
                                <i class="mgc_check_circle_line text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h5 class="fw-semibold my-0">Completed Projects</h5>
                            <p>24</p>
                        </div>
                        <div>
                            <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                                <i class="mgc_information_line text-xl"></i>
                            </button>
                            <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50"
                                role="tooltip">
                                Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded px-3 py-2">
                        <div class="flex-shrink-0 me-2">
                            <div
                                class="w-12 h-12 flex justify-center items-center rounded-full text-success bg-success/25">
                                <i class="mgc_send_line text-xl"></i>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h5 class="fw-semibold my-0">Delivery Projects</h5>
                            <p>20</p>
                        </div>
                        <div>
                            <button class="text-gray-400" data-fc-type="tooltip" data-fc-placement="top">
                                <i class="mgc_information_line text-xl"></i>
                            </button>
                            <div class="bg-slate-700 hidden px-2 py-1 rounded transition-all text-white opacity-0 z-50"
                                role="tooltip">
                                Info <div class="bg-slate-700 w-2.5 h-2.5 rotate-45 -z-10 rounded-[1px]" data-fc-arrow>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Grid End -->
@endsection

@section('script')
    @vite('resources/js/pages/dashboard.js')
@endsection
