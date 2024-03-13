<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Eficiente ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema ERP" name="description">
    <meta content="ICH Laboral" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="/images/favicon.ico">

    @yield('css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/scss/app.scss', 'resources/scss/icons.scss'])
    @vite(['resources/js/head.js', 'resources/js/config.js'])
</head>

<body>

    <div class="bg-gradient-to-r from-rose-100 to-teal-100 dark:from-gray-700 dark:via-gray-900 dark:to-black">


        <div class="h-screen w-screen flex justify-center items-center">

            <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
                <div class="card overflow-hidden sm:rounded-md rounded-none">
                    <div class="p-6">
                        <a href="#" class="block mb-8 ">
                            <img class="h-10 block dark:hidden" src="{{asset('eficiente/logos/logolight.png')}}" alt="">
                            <img class="h-14 hidden dark:block" src="{{asset('eficiente/logos/logolight.png')}}" alt="">
                        </a>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2"
                                    for="LoggingEmailAddress">Correo</label>
                                <input id="LoggingEmailAddress" class="form-input" type="email"
                                    placeholder="Ingresa tu correo" name="email">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-200 mb-2"
                                    for="loggingPassword">Contraseña</label>
                                <input id="loggingPassword" class="form-input" type="password"
                                    placeholder="Ingresa tu contraseña" name="password">
                            </div>

                            {{-- <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <input type="checkbox" class="form-checkbox rounded" id="checkbox-signin">
                                    <label class="ms-2" for="checkbox-signin">Remember me</label>
                                </div>
                                <a href="{{ route('second', ['auth', 'recoverpw']) }}"
                                    class="text-sm text-primary border-b border-dashed border-primary">Forget Password
                                    ?</a>
                            </div> --}}

                            <div class="flex justify-center mb-6">
                                <button class="btn w-full text-white bg-primary"> Ingresar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
