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
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Clientes</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Crear
                    Cliente</a>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Crear usuario</h4>
                </div>
            </div>
            <div class="p-6">

                <div class="grid lg:grid-cols-3 gap-6">
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Nombre del Usuario
                        </label>
                        <input type="text" id="simpleinput" class="form-input" name="name"
                            placeholder="Ingresa el nombre del usuario" value="{{ old('name',$user->name) }}" required>
                        @error('name')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">RFC</label>
                        <input type="text" id="rfc_input" class="form-input" name="rfc" value="{{ old('rfc') }}" placeholder="ABCD######XXX"
                            oninput="validarInput(this)">
                        <pre id="resultado"></pre>
                        @error('rfc')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Correo Electronico
                        </label>
                        <div class="relative">
                            <input type="email" id="leading-icon" name="email" value="{{ old('email',$user->email) }}"
                                class="form-input ps-11" placeholder="you@site.com">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_mail_line text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('email')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Cambiar contraseña
                        </label>
                        <div class="relative">
                            <input type="text" id="leading-icon" name="password"
                                value="{{ old('password') }}" class="form-input ps-11">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_key_2_fill text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('password')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-around my-4">
            <button type="submit" class="btn bg-success text-white rounded-full">Crear usuario</button>
        </div>
    </form>
@endsection
