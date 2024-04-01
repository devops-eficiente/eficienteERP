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
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Empleados</a>
            </div>
            <div class="flex items-center gap-2">
                <i class="mgc_right_line text-lg flex-shrink-0 text-slate-400 rtl:rotate-180"></i>
                <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Crear
                    Empleados</a>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.store_employee') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @if ($errors->any())
            <div class="my-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-muted fs-14" style="color: red !important;">
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
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
                            Apellido Paterno
                        </label>
                        <input type="text" id="simpleinput" class="form-input" name="paternal_surname"
                            value="{{ old('paternal_surname') }}">
                        @error('paternal_surname')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Apellido Materno
                        </label>
                        <input type="text" id="simpleinput" class="form-input" name="maternal_surname"
                            value="{{ old('maternal_surname') }}">
                        @error('maternal_surname')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">Nombre
                            (S)</label>
                        <input type="text" id="simpleinput" class="form-input" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">CURP</label>
                        <input type="text" id="simpleinput" class="form-input" name="curp"
                            value="{{ old('curp') }}">
                        @error('curp')
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
                    <div>
                        <label for="example-date"
                            class="text-gray-800 text-sm font-medium inline-block mb-2">Nacimiento</label>
                        <input class="form-input" id="example-date" type="date" name="birthdate">
                        @error('birthdate')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="grid lg:grid-cols-2 gap-6 my-4">
                    <div>
                        <label for="example-select" class="text-gray-800 text-sm font-medium inline-block mb-2">Instituto de
                            salud
                        </label>
                        <select class="form-select" id="example-select" name="institute_health_id">
                            <option value="">Selecciona una categoria</option>
                            @foreach ($instituteHealths as $instituteHealth)
                                <option value="{{ $instituteHealth->id }}"
                                    {{ old('institute_health_id') == $instituteHealth->id ?? 'selected' }}>
                                    {{ $instituteHealth->acronym }}</option>
                            @endforeach
                        </select>
                        @error('institute_health_id')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">NSS</label>
                        <input type="text" id="simpleinput" class="form-input" name="nss"
                            value="{{ old('nss') }}">
                        @error('nss')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="example-select" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Identificación
                        </label>
                        <select class="form-select" id="example-select" name="identification_employee_id">
                            <option value="">Selecciona una categoria</option>
                            @foreach ($identificationEmployees as $identificationEmployee)
                                <option value="{{ $identificationEmployee->id }}"
                                    {{ old('identification_employee_id') == $identificationEmployee->id ?? 'selected' }}>
                                    {{ $identificationEmployee->name }}</option>
                            @endforeach
                        </select>
                        @error('identification_employee_id')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">N.
                            Identificación</label>
                        <input type="text" id="simpleinput" class="form-input" name="n_identification"
                            value="{{ old('n_identification') }}">
                        @error('n_identification')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="grid lg:grid-cols-4 gap-6 my-4">
                    <div>
                        <label for="example-select" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Estado Civil
                        </label>
                        <select class="form-select" id="example-select" name="marital_status_id">
                            <option value="">Selecciona una categoria</option>
                            @foreach ($maritalStatus as $marital)
                                <option value="{{ $marital->id }}"
                                    {{ old('marital_status_id') == $marital->id ?? 'selected' }}>
                                    {{ $marital->name }}</option>
                            @endforeach
                        </select>
                        @error('marital_status_id')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="example-select" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Tipo de sangre
                        </label>
                        <select class="form-select" id="example-select" name="blood_type_id">
                            <option value="">Selecciona una categoria</option>
                            @foreach ($bloodTypes as $bloodType)
                                <option value="{{ $bloodType->id }}"
                                    {{ old('blood_type_id') == $bloodType->id ?? 'selected' }}>
                                    {{ $bloodType->name }}</option>
                            @endforeach
                        </select>
                        @error('blood_type_id')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="example-select" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Nacionalidad
                        </label>
                        <select class="form-select" id="example-select" name="nationality">
                            <option value="">Selecciona una categoria</option>
                            <option value="Mexicana" {{ old('nationality') == 'Mexicana' ?? 'selected' }}>
                                Mexicana</option>
                            <option value="Extrangera" {{ old('nationality') == 'Extrangera' ?? 'selected' }}>
                                Extrangera</option>
                        </select>
                        @error('nationality')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="example-select" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Genero
                        </label>
                        <select class="form-select" id="example-select" name="gender">
                            <option value="">Selecciona una categoria</option>
                            <option value="Hombre" {{ old('gender') == 'Hombre' ?? 'selected' }}>
                                Hombre</option>
                            <option value="Mujer" {{ old('gender') == 'Mujer' ?? 'selected' }}>
                                Mujer</option>
                            <option value="Otro" {{ old('gender') == 'Otro' ?? 'selected' }}>
                                Otro</option>
                        </select>
                        @error('gender')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="grid lg:grid-cols-4 gap-6 my-4">
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">Correo
                            Electronico</label>
                        <div class="relative">
                            <input type="email" id="leading-icon" name="contacts[email]"
                                value="{{ old('contacts[email]') }}" class="form-input ps-11"
                                placeholder="you@site.com">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_mail_line text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('contacts.email')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Número de celular
                        </label>
                        <div class="relative">
                            <input type="text" id="leading-icon" name="contacts[telephone]"
                                value="{{ old('contacts[telephone]') }}" class="form-input ps-11"
                                placeholder="#########">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_cellphone_line text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('contacts.telephone')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Número de telefono
                        </label>
                        <div class="relative">
                            <input type="text" id="leading-icon" name="contacts[phone]"
                                value="{{ old('contacts[phone]') }}" class="form-input ps-11" placeholder="#########">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_phone_line text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('contacts.phone')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Código postal
                        </label>
                        <input type="text" id="simpleinput" class="form-input" name="zip_code"
                            value="{{ old('zip_code') }}">
                        @error('zip_code')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-6">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h4 class="card-title">Contacto de emergecia</h4>
                </div>
            </div>
            <div class="p-6">
                <div class="grid lg:grid-cols-2 gap-6 my-4">
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Nombre
                        </label>
                        <div class="relative">
                            <input type="text" id="leading-icon" name="emergency_contacts[name]"
                                value="{{ old('emergency_contacts[name]') }}" class="form-input ps-11"
                                placeholder="Nombre completo">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_user_1_fill text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('emergency_contacts.name')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">
                            Número de celular
                        </label>
                        <div class="relative">
                            <input type="text" id="leading-icon" name="emergency_contacts[phone]"
                                value="{{ old('emergency_contacts[phone]') }}" class="form-input ps-11"
                                placeholder="#########">
                            <div class="absolute inset-y-0 start-4 flex items-center z-20">
                                <i class="mgc_cellphone_line text-lg text-gray-400"></i>
                            </div>
                        </div>
                        @error('emergency_contacts.phone')
                            <span class="text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-around my-4">
            <button type="submit" class="btn bg-success text-white rounded-full">Crear</button>
            <button type="button" class="btn bg-warning text-white rounded-full">Cancelar</button>
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
