<div>
    @if ($message->type == 'recibido')
        @if ($payload)
            <div class="flex justify-end">
                <div
                    class="flex flex-col w-11/12  leading-1.5 p-4 border-gray-400 bg-gray-300 rounded-xl dark:bg-gray-900 items-end">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                            ICH Laboral
                        </span>
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>
                    </div>
                    <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">
                        {{ $payload['payload']['title'] }}
                    </p>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Recibido</span>
                </div>
            </div>
        @endif
    @endif

    @if ($message->type == 'enviado')
        <div class="flex justify-start">
            <div
                class="flex flex-col w-11/12  leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-xl dark:bg-gray-700 items-start">
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Tú</span>
                    <span
                        class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $message->created_at->format('H:i') }}</span>
                </div>
                <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">

                    {{ $message->message }}
                </p>
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Enviado</span>
            </div>
        </div>
    @endif

    @if ($message->type == 'error')
        <div class="flex justify-center">
            <div
                class="flex flex-col w-11/12  leading-1.5 p-4 border-red-200 bg-red-100 rounded-xl dark:bg-gray-700 items-center">
                <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">
                    {{ $message->message }}
                </p>
            </div>
        </div>
    @endif

    @if ($message->type == 'end_session')
        <div class="flex justify-center">
            <div class="flex flex-col w-11/12  leading-1.5 p-4 border-gray-200 bg-gray-600 rounded-xl items-center">
                <p class="text-sm font-normal py-2.5 text-white">
                    {{ $message->message }}
                </p>
            </div>
        </div>
    @endif
</div>
