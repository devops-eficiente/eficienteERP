@if ($msg = Session::get('success'))
    <div id="dismiss-alert" class="transition duration-300 bg-green-600 rounded-md p-4 absolute z-50 right-10 top-20"
        role="alert">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <i class="mgc_-badge-check text-xl"></i>
            </div>
            <div class="flex-grow">
                <div class="text-sm text-white font-medium">
                    {{ $msg }}
                </div>
            </div>
            <button data-fc-dismiss="dismiss-alert" type="button" id="dismiss-test"
                class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                <i class="mgc_close_line text-xl"></i>
            </button>
        </div>
    </div>
@endif
@if ($msg = Session::get('denied'))
    <div id="dismiss-alert" class="transition duration-300 bg-red-400 rounded-md p-4 absolute z-50 right-10 top-20"
        role="alert">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <i class="mgc_information_fill text-xl text-white"></i>
            </div>
            <div class="flex-grow">
                <div class="text-sm text-white font-medium">
                    {{ $msg }}
                </div>
            </div>
            <button data-fc-dismiss="dismiss-alert" type="button" id="dismiss-test"
                class="ms-auto h-8 w-8 rounded-full bg-gray-200 flex justify-center items-center">
                <i class="mgc_close_line text-xl"></i>
            </button>
        </div>
    </div>
@endif
