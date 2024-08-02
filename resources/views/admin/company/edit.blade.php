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
    <form action="{{ route('admin.company.update',$company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Datos Generales de la Empresa</h4>
                </div>
            </div>
            <div class="p-6">

                <div class="grid lg:grid-cols-4 gap-6">
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Nombre de la empresa
                        </label>
                        <input type="text" id="simpleinput" class="form-input" name="bussines_name"
                            placeholder="Ingresa el nombre" value="{{ old('bussines_name',$company->bussines_name) }}" required>
                        @error('bussines_name')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">RFC</label>
                        <input type="text" id="rfc_input" class="form-input" name="rfc" value="{{ old('rfc',$company->rfc) }}"
                            placeholder="ABCD######XXX" oninput="validarInput(this)">
                        <pre id="resultado"></pre>
                        @error('rfc')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Correo Electronico
                        </label>
                        <div class="relative">
                            <input type="email" id="leading-icon" name="email" value="{{ old('email',$company->email) }}"
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
                            Número de celular
                        </label>
                        <div class="relative">
                            <input type="text" id="leading-icon" name="telephone" value="{{ old('telephone',$company->phone) }}"
                                class="form-input ps-11" placeholder="#########">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_cellphone_line text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('telephone')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Asignación de módulos</h4>
                </div>
            </div>
            <div class="p-6">

                <div class="grid lg:grid-cols-3 gap-6">
                    <div class="flex gap-6 my-4 flex-col">
                        <div>
                            <h6 class="text-sm mb-2">Selecciona los módulos de la empresa</h6>
                            @error('modules')
                                <span class="text-red-800">{{ $message }}</span>
                            @enderror
                            <div class="flex gap-4 flex-row">
                                @foreach ($modules as $module)
                                    <div class="form-check flex gap-2">
                                        <input type="checkbox" class="form-checkbox rounded text-primary" {{$company->modules->contains($module) ? 'checked': ''}}
                                            value="{{ $module->id }}" name="modules[]"
                                            id="customCheck{{ $module->id }}">
                                        <label class="ms-1.5" for="customCheck{{ $module->id }}">
                                            {{ $module->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-around my-4">
            <button type="submit" class="btn bg-success text-white rounded-full">Guardar empresa</button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        //Función para validar un RFC
        // Devuelve el RFC sin espacios ni guiones si es correcto
        // Devuelve false si es inválido
        // (debe estar en mayúsculas, guiones y espacios intermedios opcionales)
        function rfcValido(rfc, aceptarGenerico = true) {
            const re =
                /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            var validado = rfc.match(re);

            if (!validado) //Coincide con el formato general del regex?
                return false;

            //Separar el dígito verificador del resto del RFC
            const digitoVerificador = validado.pop(),
                rfcSinDigito = validado.slice(1).join(''),
                len = rfcSinDigito.length,

                //Obtener el digito esperado
                diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
                indice = len + 1;
            var suma,
                digitoEsperado;

            if (len == 12) suma = 0
            else suma = 481; //Ajuste para persona moral

            for (var i = 0; i < len; i++)
                suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
            digitoEsperado = 11 - suma % 11;
            if (digitoEsperado == 11) digitoEsperado = 0;
            else if (digitoEsperado == 10) digitoEsperado = "A";

            //El dígito verificador coincide con el esperado?
            // o es un RFC Genérico (ventas a público general)?
            if ((digitoVerificador != digitoEsperado) &&
                (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
                return false;
            else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
                return false;
            return rfcSinDigito + digitoVerificador;
        }


        //Handler para el evento cuando cambia el input
        // -Lleva la RFC a mayúsculas para validarlo
        // -Elimina los espacios que pueda tener antes o después
        function validarInput(input) {
            var rfc = input.value.trim().toUpperCase(),
                resultado = document.getElementById("resultado"),
                valido;

            var rfcCorrecto = rfcValido(rfc); // ⬅️ Acá se comprueba

            if (rfcCorrecto) {
                valido = "Válido";
                resultado.classList.add("ok");
            } else {
                valido = "No válido"
                resultado.classList.remove("ok");
            }

            resultado.innerText = "Formato: " + valido;
        }
    </script>
@endsection
