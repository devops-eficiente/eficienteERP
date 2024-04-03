<div>
    <button class="text-primary hover:text-sky-700" data-fc-target="modalDocument" data-fc-type="modal" type="button">
        Verificar RFC
    </button>
    <div id="modalDocument"
        class="w-full h-full mt-5 fixed top-0 left-0 z-50 transition-all duration-500 fc-modal hidden">
        <div
            class="sm:max-w-2xl fc-modal-open:opacity-100 duration-500 opacity-0 ease-out transition-all sm:w-full m-3 sm:mx-auto flex flex-col bg-white border shadow-sm rounded-md">
            <form action="{{ route('admin.uploadDocument') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-between items-center py-2.5 px-4 border-b ">
                    <h3 class="font-medium text-gray-800 text-lg">
                        Subir Cédula de identificación fiscal
                    </h3>
                    <button class="inline-flex flex-shrink-0 justify-center items-center h-8 w-8" data-fc-dismiss
                        type="button">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
                <div class="px-4 py-8 flex">

                    <div class="w-full">
                        <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">Subir
                            documento</label>
                        <p class="text-xs">
                            Unicamente documento PDF*
                        </p>
                        <input type="file" id="simpleinput" class="form-input" accept="application/pdf"
                            name="pdf">
                            @error('pdf')
                                <span class="text-xs text-red-800">{{$message}}</span>
                            @enderror
                    </div>
                </div>
                <div class="flex justify-end items-center gap-4 p-4 border-t ">
                    <button
                        class="btn  border border-slate-200 dark:border-slate-700 hover:bg-slate-100  transition-all"
                        data-fc-dismiss type="button">
                        Cancelar
                    </button>
                    <button class="btn bg-primary text-white" href="javascript:void(0)">
                        Subir
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal toggle -->
