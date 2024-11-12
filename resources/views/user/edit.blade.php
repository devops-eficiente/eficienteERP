@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h4 class="text-lg font-medium text-slate-900 dark:text-slate-200">Eficiente ERP</h4>
        <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
            <div class="flex items-center gap-2">
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Eficiente</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="flex-shrink-0 text-lg mgc_right_line text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Clientes</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="flex-shrink-0 text-lg mgc_right_line text-slate-400 rtl:rotate-180"></i>
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
                <div class="flex items-center justify-between">
                    <h4 class="card-title">Crear usuario</h4>
                </div>
            </div>
            <div class="p-6">

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label for="simpleinput" class="inline-block mb-2 text-sm font-medium text-gray-800">
                            Nombre del Usuario
                        </label>
                        <input type="text" id="simpleinput" class="form-input" name="name"
                            placeholder="Ingresa el nombre del usuario" value="{{ old('name',$user->name) }}" required>
                        @error('name')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div>
                        <label for="simpleinput" class="inline-block mb-2 text-sm font-medium text-gray-800">RFC</label>
                        <input type="text" id="rfc_input" class="form-input" name="rfc" value="{{ old('rfc') }}" placeholder="ABCD######XXX"
                            oninput="validarInput(this)">
                        <pre id="resultado"></pre>
                        @error('rfc')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    <div>
                        <label for="simpleinput" class="inline-block mb-2 text-sm font-medium text-gray-800">
                            Correo Electronico
                        </label>
                        <div class="relative">
                            <input type="email" id="leading-icon" name="email" value="{{ old('email',$user->email) }}"
                                class="form-input ps-11" placeholder="you@site.com">
                            <div class="absolute inset-y-0 z-20 flex items-center start-4">
                                <i class="text-lg text-gray-400 mgc_mail_line"></i>
                            </div>
                        </div>
                        @error('email')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="inline-block mb-2 text-sm font-medium text-gray-800">
                            Celular
                        </label>
                        <div class="relative">
                            <input type="text" id="leading-icon" name="phone" value="{{ old('phone',$user->phone) }}"
                                class="form-input ps-11" placeholder="961#######">
                            <div class="absolute inset-y-0 z-20 flex items-center start-4">
                                <i class="text-lg text-gray-400 mgc_mail_line"></i>
                            </div>
                        </div>
                        @error('phone')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="inline-block mb-2 text-sm font-medium text-gray-800">
                            Cambiar contraseña
                        </label>
                        <div class="relative">
                            <input type="text" id="leading-icon" name="password"
                                value="{{ old('password') }}" class="form-input ps-11">
                            <div class="absolute inset-y-0 z-20 flex items-center start-4">
                                <i class="text-lg text-gray-400 mgc_key_2_fill"></i>
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
            <button type="submit" class="text-white rounded-full btn bg-success">Guardar usuario</button>
        </div>
    </form>
@endsection
