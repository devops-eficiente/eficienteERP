<div>
    @if ($message->type == 'enviado')
        <div class="flex justify-end">
            <div
                class="flex flex-col w-11/12  leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-xl dark:bg-gray-700 items-end">
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Bonnie
                        Green</span>
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>
                </div>
                <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">That's
                    awesome.
                    I
                    think our users will really appreciate the improvements.</p>
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Delivered</span>
            </div>
        </div>
    @endif
    @if ($message->type == 'recibido')
        <div class="flex justify-start">
            <div
                class="flex flex-col w-11/12  leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-xl dark:bg-gray-700 items-start">
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">Tú</span>
                    <span
                        class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $message->created_at->format('H:i') }}</span>
                </div>
                <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">
                    {{-- {{ $payload }} --}}
                </p>
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Delivered</span>
            </div>
        </div>
    @endif
</div>
