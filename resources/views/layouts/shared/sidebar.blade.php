<div class="app-menu">

    <!-- Sidenav Brand Logo -->
    <a href="#" class="logo-box">
        <!-- Light Brand Logo -->
        <div class="logo-light">
            <img src="/images/logo-light.png" class="logo-lg h-6" alt="Light logo">
            <img src="{{asset('eficiente/logos/iconlogo.png')}}" class="logo-sm rounded-xl" alt="Small logo">
        </div>

        <!-- Dark Brand Logo -->
        <div class="logo-dark">
            <img src="/images/logo-dark.png" class="logo-lg h-6" alt="Dark logo">
            <img src="{{asset('eficiente/logos/iconlogo.png')}}" class="logo-sm rounded-xl" alt="Small logo">
        </div>
    </a>

    <!-- Sidenav Menu Toggle Button -->
    <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5">
        <span class="sr-only">Menu Toggle Button</span>
        <i class="mgc_round_line text-xl"></i>
    </button>

    <!--- Menu -->
    <div class="srcollbar" data-simplebar>
        <ul class="menu" data-fc-type="accordion">
            <li class="menu-title">Inicio</li>

            <li class="menu-item">
                <a href="{{route('index')}}" class="menu-link">
                    <span class="menu-icon"><i class="mgc_home_3_line"></i></span>
                    <span class="menu-text"> Dashboard </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="mgc_user_5_fill"></i></span>
                    <span class="menu-text"> Empleados </span>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="mgc_coin_fill"></i></span>
                    <span class="menu-text"> Finanzas </span>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="mgc_chart_line_fill"></i></span>
                    <span class="menu-text"> Contabilidad </span>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="mgc_chart_bar_line"></i></span>
                    <span class="menu-text"> Reportes </span>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i class="mgc_wallet_4_fill"></i></span>
                    <span class="menu-text"> Nominas </span>
                </a>
            </li>

        </ul>
    </div>
</div>
<!-- Sidenav Menu End  -->
