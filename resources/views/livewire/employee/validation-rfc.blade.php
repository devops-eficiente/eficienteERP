<div>
    <div class="card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h4 class="card-title">Verificacion masiva</h4>
            </div>
            <div class="w-full flex md:flex-row flex-col justify-center my-2 py-4 gap-6">
                <div class="border border-blue-500 {{ $step >= 1 ? 'bg-blue-500' : '' }} px-3 py-2 rounded-full">
                    <i class="mgc_check_2_fill text-xl {{ $step >= 1 ? 'text-white' : '' }}"></i>
                </div>
                <div class="border border-blue-500 {{ $step > 1 ? 'bg-blue-500' : '' }} px-3 py-2 rounded-full">
                    <i class="mgc_download_2_fill text-xl {{ $step > 1 ? 'text-white' : '' }}"></i>
                </div>
                <div class="border border-blue-500 {{ $step > 2 ? 'bg-blue-500' : '' }} px-3 py-2 rounded-full">
                    <i class="mgc_question_fill text-xl {{ $step > 2 ? 'text-white' : '' }}"></i>
                </div>
                <div class="border border-blue-500 px-3 py-2 rounded-full {{ $step > 3 ? 'bg-blue-500' : '' }}">
                    <i class="mgc_upload_2_fill text-xl  {{ $step > 3 ? 'text-white' : '' }}"></i>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.uploadResponseSat') }}" method="POST" enctype="multipart/form-data">
                <div class="p-6 flex flex-col w-full gap-6">
                    @if ($step == 1)
                        <div class="flex items-center text-center">
                            <h4 class="card-title">Preparacion del archivo para validacion del SAT</h4>
                        </div>
                        <div class="flex items-center text-center">
                            <p>
                                Selecciona una de las opciones para exportar, ten en cuenta que el SAT solo permite 500
                                registros por cada archivo.
                            </p>
                        </div>
                        <div>
                            <ul class="flex w-full justify-center items-center gap-6 flex-col">
                                <li class="w-96">
                                    <input type="radio" id="rfc_invalid" name="option" value="rfc_invalid"
                                        wire:model.lazy='option' class="hidden peer" required />
                                    <label for="rfc_invalid"
                                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            <div class="w-full text-lg font-semibold">Solo empleados con RFC invalidos
                                            </div>
                                            <div class="w-full">Solo aquellos que tienen el RFC invalido</div>
                                        </div>
                                    </label>
                                </li>
                                <li class="w-96">
                                    <input type="radio" id="all_active" name="option" value="all_active"
                                        wire:model.lazy='option' class="hidden peer">
                                    <label for="all_active"
                                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            <div class="w-full text-lg font-semibold">Todos los empleados activos</div>
                                            <div class="w-full">Se consideran a todos los empleados incluyendo los que
                                                tengan el
                                                RFC validado y activos. </div>
                                        </div>
                                    </label>
                                </li>
                                <li class="w-96">
                                    <input type="radio" id="all" name="option" value="all"
                                        wire:model.lazy='option' class="hidden peer">
                                    <label for="all"
                                        class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <div class="block">
                                            <div class="w-full text-lg font-semibold">Toda la plantilla</div>
                                            <div class="w-full">Esta opcion es para validar a todos los empleados
                                                incluyendo
                                                bajas.</div>
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    @endif
                    @if ($step == 2)
                        <div class="w-full justify-center items-center flex">


                            <div
                                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="{{ route('admin.export_rfc', ['opcion' => $option]) }}">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        Descarga de archivos
                                    </h5>
                                </a>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                    Descarga los archivos que se usaran para validarlo en el sitio del SAT. Despues de
                                    descargarlos da clic en siguiente.
                                </p>
                                <a href="{{ route('admin.export_rfc', ['opcion' => $option]) }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Descargar
                                </a>
                            </div>

                        </div>
                    @endif
                    @if ($step == 3)
                        <div class="w-full justify-center items-center flex">
                            <div
                                class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="https://agsc.siat.sat.gob.mx/PTSC/ValidaRFC/index.jsf">
                                    <img class="rounded-t-lg" src="{{ asset('eficiente/logos/sat.jpg') }}"
                                        alt="" />
                                </a>
                                <div class="p-5">
                                    <a href="#">
                                        <h5
                                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            Ingresa al portal del SAT
                                        </h5>
                                    </a>
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                        En este paso debes ingresar al portal del SAT. Elegir la opcion de validacion
                                        masiva
                                        y seguir con los pasos que se indiquen en la pagina.
                                        Una vez validado y obtenido el archivo de respuesta del SAT, dar clic en
                                        siguiente y
                                        subir los archivos.
                                    </p>
                                    <a href="https://agsc.siat.sat.gob.mx/PTSC/ValidaRFC/index.jsf" target="_blank"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Ir al SAT
                                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($step == 4)
                        <div class="w-full justify-center items-center flex">


                            <div
                                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="{{ route('admin.export_rfc', ['opcion' => $option]) }}">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        Cargar Archivo de respuesta
                                    </h5>
                                </a>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                    Selecciona el archivo que obtuviste en el portal del SAT y haz clic en el boton de
                                    validar.
                                </p>
                                <form action="{{ route('admin.uploadResponseSat') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                        for="file_input">Subir archivo</label>
                                    <input
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="file_input" type="file" name="archivo" accept=".txt" required>
                            </div>

                        </div>
                    @endif
                </div>
                <div
                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 justify-around">
                    <a href="{{ route('admin.employees') }}"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Atras
                    </a>
                    <button type="button" wire:click='lessStep' class="btn bg-secondary text-white"
                        {{ $step == 1 ? 'disabled' : '' }}>
                        Regresar
                    </button>
                    <button type="button" wire:click='addStep' {{ $step == 4 ? 'hidden' : '' }}
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Siguiente
                    </button>
                    @if ($step == 4)
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Validar
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
