<div>
    <button class="btn bg-info text-white" data-fc-type="modal" type="button">
        Subir datos manuales
    </button>
    <div class="w-full h-full mt-5 fixed top-0 left-0 z-50 transition-all duration-500 fc-modal hidden">
        <div
            class="sm:max-w-2xl fc-modal-open:opacity-100 duration-500 opacity-0 ease-out transition-all sm:w-full m-3 sm:mx-auto flex flex-col bg-white border shadow-sm rounded-md">
            <form action="{{ route('admin.client.check_rfc', $person->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-between items-center py-2.5 px-4 border-b">
                    <h3 class="font-medium text-gray-800">
                        Ingresar datos manuales
                    </h3>
                    <button class="inline-flex flex-shrink-0 justify-center items-center h-8 w-8" data-fc-dismiss
                        type="button">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
                <div class="px-4 py-8">
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 my-2">
                        <div>
                            <label for="simpleinput"
                                class="text-gray-800 text-sm font-medium inline-block mb-2">RFC</label>
                            <p class="text-xs">
                                Debe tener 13 caracteres.
                            </p>
                            <input type="text" id="simpleinput" class="form-input" name="rfc">
                        </div>
                        <div>
                            <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">id
                                CIF</label>
                            <p class="text-xs">
                                Debe tener 11 caracteres.
                            </p>
                            <input type="text" id="simpleinput" class="form-input" name="cif">
                        </div>
                    </div>
                    <div class="flex justify-end items-center gap-4 p-4 border-t">
                        <button class="btn border border-slate-200  hover:bg-slate-100 transition-all" data-fc-dismiss
                            type="button">
                            Cerrar
                        </button>
                        <button class="btn bg-primary text-white" type="submit">
                            Enviar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
