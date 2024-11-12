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
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Usuarios</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="flex-shrink-0 text-lg mgc_right_line text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">
                    Todos las usuarios
                </a>
            </div>
        </div>
    </div>
    <div class="flex flex-col items-center justify-around w-full my-4 md:flex-row">
        <a href="{{ route('admin.user.create') }}" class="text-white btn bg-secondary">
            Crear Usuario
        </a>
    </div>
    <div class="card">
        <div class="card-header">

            <div class="flex items-center justify-between">
                <h4 class="card-title">Usuario</h4>
            </div>
        </div>
        <div class="p-6 card-body">
            <div class="overflow-x-auto overflow-y-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overscroll-y-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 overscroll-y-auto">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Usuario
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Correo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">
                                        Accion
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap ">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap ">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-center whitespace-nowrap">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    <a class="border rounded-full btn border-success text-success hover:bg-success hover:text-white"
                                                        href="{{ route('admin.user.edit', $user->id) }}">
                                                        Ver y editar
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.send_notification', $user->id) }}"
                                                        class="border rounded-full btn border-success text-success hover:bg-success hover:text-white" type="button">
                                                        Enviar notificacion
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
        <div class="p-6 card-footer">
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
