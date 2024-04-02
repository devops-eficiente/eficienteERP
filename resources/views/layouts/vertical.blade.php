<!DOCTYPE html>
<html lang="en" data-sidenav-view="{{ $sidenav ?? 'default' }}">

<head>
    <meta charset="utf-8">
    <title>Eficiente ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema ERP" name="description">
    <meta content="ICH Laboral" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('eficiente/logos/icono.png') }}">

    @yield('css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    @vite(['resources/scss/app.scss', 'resources/scss/icons.scss'])
    @vite(['resources/js/head.js', 'resources/js/config.js'])

</head>

<body>

    <div class="flex wrapper">

        @include('layouts.shared/sidebar')

        <div class="page-content">

            @include('layouts.shared.alerts')
            @include('layouts.shared/topbar')

            <main class="flex-grow p-6">

                @yield('content')

            </main>

            @include('layouts.shared/footer')

        </div>

    </div>

    @include('layouts.shared/customizer')

    <!-- bundle -->
    @yield('script')
    <!-- App js -->
    @yield('script-bottom')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    @vite(['resources/js/app.js'])

</body>


</html>
