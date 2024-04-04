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
                    Verificacion Masiva
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h4 class="card-title">Verificacion masiva de empleados</h4>
            </div>
        </div>
        <div class="p-6">

        </div>
    </div>
    {{--
        <div class="flex justify-around my-3">
            <a href="{{ route('admin.employees') }}" class="btn bg-secondary text-white">Regresar</a>
            @if ($cont == 0)
                <a href="{{ route('admin.continue_employee') }}" class="btn bg-success text-white">Continuar</a>
            @else
                <a href="{{ route('admin.edit_data_employee') }}" class="btn bg-warning text-white">Corregir errores</a>
            @endif
        </div>
    --}}
@endsection
