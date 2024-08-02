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
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Usuarios</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">
                    Todos las usuarios
                </a>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row my-4 justify-around items-center w-full">
        <a href="{{ route('admin.user.create') }}" class="btn bg-secondary text-white">
            Crear Usuario
        </a>
    </div>
    <div class="card">
        <div class="card-header">

            <div class="flex justify-between items-center">
                <h4 class="card-title">Usuario</h4>
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
                                        Usuario
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Correo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Accion
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex flex-col gap-4">
                                                <div>
                                                    <a class="btn rounded-full border border-success text-success hover:bg-success hover:text-white"
                                                        href="{{ route('admin.user.edit', $user->id) }}">
                                                        Ver y editar
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
            {{ $users->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
