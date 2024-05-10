<form wire:submit.prevent="submitForm">
    <div class="flex flex-col gap-6 p-10">

        @if ($search)
            <button type="button" class="btn bg-primary text-white" wire:click.prefetch='delete'>Solicitar nueva</button>
        @else
            <div>
                <label for="simpleinput" class="text-gray-800 text-sm font-medium inline-block mb-2">Ingresa el
                    motivo</label>
                <input type="text" id="simpleinput" class="form-input" wire:model.lazy='motivo' placeholder="Ingresa el motivo" required>
            </div>
            <button type="submit" class="btn bg-success text-white">Enviar solicitud</button>
        @endif
    </div>
    <br>
    @if ($search)
        <div class="p-6 card-body">
            <div class="overflow-y-auto overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overscroll-y-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 overscroll-y-auto">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Causa
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Motivo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Mensaje
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $devolucionId }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $causa }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $motivo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                        {{ $mensaje }}
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</form>
