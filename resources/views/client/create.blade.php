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
    <form action="{{ route('admin.store_client') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{--
            @if ($errors->any())
                <div class="my-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-muted fs-14" style="color: red !important;">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        --}}
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Datos Generales</h4>
                </div>
            </div>
            <div class="p-6">

                <div class="grid lg:grid-cols-3 gap-6">
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Razón social
                        </label>
                        <input type="text" id="simpleinput" class="form-input" name="company_name"
                            value="{{ old('company_name') }}" required>
                        @error('company_name')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>

                        <div>
                            <label for="example-select" class="text-gray-800 text-sm font-medium inline-block mb-2">Regimen
                                de capital</label>
                            <select class="form-select" id="example-select" name="capital_regime_id" required>
                                <option value="">Selecciona el regimen</option>
                                @foreach ($capitalRegimes as $capitalRegime)
                                    <option value="{{ $capitalRegime->id }}">{{ $capitalRegime->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('capital_regime')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">RFC</label>
                        <input type="text" id="rfc_input" class="form-input" name="rfc" value="{{ old('rfc') }}"
                            oninput="validarInput(this)">
                        <pre id="resultado"></pre>
                        @error('rfc')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="grid lg:grid-cols-4 gap-6 my-4">
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">Correo
                            Electronico</label>
                        <div class="relative">
                            <input type="email" id="leading-icon" name="email" value="{{ old('email') }}"
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
                            <input type="text" id="leading-icon" name="phone" value="{{ old('phone') }}"
                                class="form-input ps-11" placeholder="#########">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_cellphone_line text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('phone')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Código postal
                        </label>
                        <input type="text" id="simpleinput" class="form-input" name="zip_code"
                            value="{{ old('zip_code') }}" required>
                        @error('zip_code')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>

                        <div>
                            <label for="example-select" class="text-gray-800 text-sm font-medium inline-block mb-2">
                                Tipo de regimen
                            </label>
                            <select class="form-select" id="example-select" name="regimen" required>
                                <option value="">Selecciona el tipo de regimen</option>
                                <option value="fisica">Fisica</option>
                                <option value="moral">Moral</option>

                            </select>
                        </div>
                        @error('capital_regime')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex gap-6 my-4 flex-col">
                    <div>
                        <h6 class="text-sm mb-2">Selecciona el Regimen fiscal</h6>
                        @error('tax_regimes')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                        <div class="grid grid-cols-3 gap-4">
                            @foreach ($taxRegimes as $taxRegime)
                                <div class="form-check flex gap-2">
                                    <input type="checkbox" class="form-checkbox rounded text-primary" value="{{$taxRegime->id}}" name="tax_regimes[]"
                                        id="customCheck{{ $taxRegime->id }}">
                                    <label class="ms-1.5" for="customCheck{{ $taxRegime->id }}">
                                        {{ $taxRegime->code }}
                                        -
                                        {{ $taxRegime->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-around my-4">
            <button type="submit" class="btn bg-success text-white rounded-full">Crear</button>
            <button type="button" class="btn bg-warning text-white rounded-full">Cancelar</button>
        </div>
    </form>
    @livewire('components.upload-document', ['type' => 'client'])
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
